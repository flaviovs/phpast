PHPAST - PHP Abstract Syntax Tree Structure and Interpreter
===========================================================

The PHPAST package provides an [Abstract Syntax Tree] (AST) structure, plus
an interpreter to run programs represented by those structures. PHPAST
provides not only all the operators commonly found in programming languages,
such as addition, subtraction, logical operators ("and", "or", "not", "xor),
etc., but also flow control structures ("if"), loops ("while", "for"). You
can use variables, define functions -- both statically, or by using AST
calls, which allow dynamic routines to be created --, and call pre-defined
PHP built-ins or callbacks. This makes PHPAST extremely versatile and
powerful, and allows you to power your custom programming language and do
virtually anything a full-fledged language can do.

*Note*: this package contains only the AST structure and interpreter, to be
used as the intermediate representation of a programming language. To
properly implement a language you will need a parser to convert lexical
constructions into the ASTs.


Installation
------------

The easiest way to install and run PHPAST is through [Composer]:

    $ composer require flaviovs/phpast

## Running without composer ##

To run PHP without composer you must load the core library files, and
implement a PSR-4 style auto-loader, pointing the `PHPAST` namespace to the
`src/` directory:

```php
require 'path/to/phpast/src/core/except.php';
require 'path/to/phpast/src/core/types.php';

$my_autoloader->addPSR4('PHPAST', 'path/to/phpast/src');
```

Basic Usage
-----------

The core concept of PHPAST (and ASTs in general) is the _evaluation node_,
which comprises of objects that, once evaluated against a symbol table,
produces another node. ASTs are organized as trees (duh!), so nodes can have
children nodes which are also evaluated according to the operation to be
carried by the parent node. Ultimately, the root node (your main program)
returns the node that represents the complete evaluation of the tree --
which is the output of your "program".

Let's look at a basic example:

```php
// First, create a symbol table for our "program".
$table = new PHPAST\FlatSymbolTable();

// Our "program" will contain only the integer value 1. It is very dumb, so
// once it is run (evaluated), it should just return the same integer value.
$program = new PHPAST\Integer(1);

// Now let's run our program
$output = $program->evaluate($table);
```

At this point, `$output` contains the results of evaluating our program,
contained in the `$program` variable. Since our "program" is comprised of
just a node representing the literal number _1_, this very same node is
returned. In other words, after running the code above, `$output` is the
same as `$program`.

Notice that to evaluate a node you must provide a symbol table
object. Symbol tables are like PHP arrays, and are used by PHPAST to hold
program variables. We will cover symbol tables later, so for now just accept
that they are required, and work like PHP arrays. In the example above we
used `$table` to hold our symbol table.

Now let's look at a more complex example:

```php
$table = new PHPAST\FlatSymbolTable();

// Lets' define some values
$number1 = new PHPAST\Integer(2);
$number2 = new PHPAST\Integer(4);

// Our program now will multiply the two integers.
$program = new PHPAST\MulOp($number1, $number2);

// Now let's run our program
$output = $program->evaluate($table);
```

Whoa there! Things are becoming a bit more complicated. The program above is
composed of a `MulOp` node, which receives two `Integer` nodes --
representing _2_ and _4_. `MulOp` is the node operation (hence the _Op_)
corresponding to the *mul*tiplication operation. What it does is to multiply
its two nodes operands, so when you run the program above, `$output` will be
equivalent to an `PHPAST\Integer(8)` object (_8_ being the result of _2 ×
4_).

Now an even more complex program:

```php
$number1 = new PHPAST\Integer(2);
$number2 = new PHPAST\Integer(4);

// Our program now will multiply the two integers.
$program = new PHPAST\MulOp(
	new PHPAST\AddOp($number1, $number2),
	new PHPAST\SubOp($number1, $number2)
);

// Now let's run our program
$output = $program->evaluate($table);
```

Did I say that PHPASTs programs are hierarchical structures? In the example
above, the nodes passed to `MulOp` are nodes of type `AddOp` and `SubOp`. As
you may already figured out, these two represents arithmetic _addition_ and
_subtraction_. In this example, `$output` will be equivalent to an
`PHPAST\Integer(-12)` object (_(2 + 4) * (2 - 4)_).

This is the beauty of ASTs: by combining small, self-contained
operation-nodes, you can create very complex programs.


Symbol Tables
-------------

As described above, a symbol table is required to evaluate a node. Symbol
tables are like PHP arrays which you can use to assign a value to an indexed
element. The different is that on a symbol table you assign nodes to a
symbol (which is just a fancy name for "indexed element").

In fact, symbol tables implements the standard PHP array access syntax:

```php
$table = new PHPAST\FlatSymbolTable();
$table['foo'] = new PHPAST\String('bar');
$table['launch'] = PHPAST\Boolean::getFalse();

if ($table['launch'] === PHPAST\Boolean::getTrue()) {
    print "Launch\n";
}
```

The syntax above is just to illustrate the expected behaviour of a symbol
table. *Usually you will not be writing code to manipulate symbol tables* --
they will be handled by PHPAST, and the symbol/values managed by your PHPAST
program.

`FlatSymbolTable` is the simplest symbol table, which works exactly like an
PHP array. PHPAST also provides a `ChainedScopeSymbolTable` class, which can
be used to implement local/global variables. You are free to choose any
symbol table best suits your language, or even define your own.


Variables
---------

Variables are entries in a symbol table, indexed by an identifier, which
ultimately is used as the index to the node on the symbol table. PHPAST
provides several nodes to handle basic variable operations. Let's look at
some examples:

```php
use PHPAST\FlatSymbolTable;
use PHPAST\Integer;
use PHPAST\Float;
use PHPAST\Ref;
use PHPAST\Identifier;
use PHPAST\AssignOp;
use PHPAST\PowerOp;
use PHPAST\Outln;

// Create and initialize a symbol table.
$table = new FlatSymbolTable(['foo' => new Float(0)]);

// Create a 'foo' identifier. Identifiers work pretty much like as an ordinary
// string value. All variable reference must be done using identifiers, so we
// here we create one.
$foo_id = new Identifier('foo');

// Now create a reference to the variable.
$foo_ref = new Ref($foo_id);

// This program will assign Float(3.14159) to 'foo'. This would be the
// equivalent of the following construct in PHP:
//
//    $foo = 3.14159;
$program = new AssignOp($foo_ref, new Float(3.14159));

// Now let's run our program.
$program->evaluate($table);

// This should print the 'foo' entry in the symbol table with the value 3.14159.
print_r($table['foo']);

// $bar = $foo ** 2
$bar_ref = new Ref(new Identifier('bar'));
$program = new AssignOp($bar_ref, new PowerOp($foo_ref, new Integer(2)));
$program->evaluate($table);

// Let's use the Outln operation to print the newly created 'bar' variable.
// This should print "3.14159 to the power of two is 9.8695877281".
$program  = new Outln([
	                      $foo_ref,
	                      " to the power of two is ",
	                      $bar_ref,
                      ]);
$program->evaluate($table);
```

String Representation
---------------------

PHPAST nodes have human-friendly (err... programmer-friendly) string
representation of its node operations. This can be helpful to understand
and/or debug PHPAST programs. To print the string representation, just use
the node object on a string context. For example:

```php
$table = new FlatSymbolTable(['foo' => new Float(0)]);
$foo_ref = new Ref(new Identifier('foo'));
$program = new Outln([
	                     new PowerOp(new Float(3.14159),
	                                 new Integer(2)),
                     ]);
print "$program\n";
```

This should print

    Outln (3.14159 ** 2)

*Note*: the string representation output by PHPAST does not serve as -- and
was never meant to be -- a full-featured programming language. It is just a
naive representation of the inner operation to be carried by a node.


Complex Operations
------------------

PHPAST also provides nodes that perform complex operations, such as program
flow control and functions. Below are the description of some of these
structures. Please refer to the classes in the `src/` directory for a
complete list of PHPAST operators.

## Prog ##

This primitive node is used to evaluate several child nodes in sequence. The
result of evaluation of the last node is returned. The node implements
[ArrayAccess], so a `Prog` can be manipulated using ordinary PHP array
syntax. `Prog`s are the building blocks to evaluate sequences of nodes in
function bodies, control structures, and programs.

Example:

```php
$foo_ref = new Ref(new Identifier('foo'));
$bar_ref = new Ref(new Identifier('bar'));
$prog = new Prog();

// $foo = 0;
// $bar = 1;
$prog[] = new AssignOp($foo_ref, new Integer(0));
$prog[] = new AssignOp($bar_ref, new Integer(1));

// $bar += 10
$prog[] = new IncOp($foo_ref, 10);

// for(;$foo > $bar; $foo -= 2) { print "foo = $foo\n"; }
$prog[] = new ForOp(new Nop(),
                    new GtOp($foo_ref, $bar_ref),
                    new DecOp($foo_ref, 2),
                    new Outln([ "foo = ", $foo_ref ]));

print "$prog\n";
```

This should print:

    foo := 0
    bar := 1
    foo += 10
    For (Nop; (foo > bar); foo -= 2)
            Outln "foo = ", foo


## Func & ReturnOp ##

`Func` nodes represent functions. Each function has an `ArgList` object that
defines the arguments the function expects.

`Func` is a subclass of `Prog`, so its "array" elements define the nodes
that make up the body of the function.

Like `Prog`, `Func` return the evaluation of last node. You can use a
`ReturnOp` to end function evaluation and return an specific node.


## Def & CallOp ##

With `Def` you can define a function, which basically means assigning a
function body to a symbol in the symbol table. To "call" the function, use
`CallOp` with a `Ref` to the symbol that defines the function, and a
`SymbolTable` object that defines the function arguments.


Examples
--------

The `examples/` directory contains some examples of how to use PHPAST.


Support
-------

Home page: https://github.com/flaviovs/phpast



[Abstract Syntax Tree]: https://en.wikipedia.org/wiki/Abstract_syntax_tree
[ArrayAccess]: http://php.net/manual/en/class.arrayaccess.php
[Composer]: https://getcomposer.org/
