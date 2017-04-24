<?php

namespace PHPAST;

require __DIR__ . '/../vendor/autoload.php';


//
// Create the factorial function.
//

// First create our function identifier, since we will be calling it
// recursively.
$factorial_id = new Identifier('factorial');
$factorial = new Func(new ArgList(['num']), []);
$num = new Identifier('num');
$factorial[] = new IfOp(new Eq(new Ref($num), new Integer(1)),
                        new Prog(
	                        [
		                        new ReturnOp(new Integer(1)),
	                        ])
);

$factorial[] = new ReturnOp(
	new MulOp(new Ref($num),
	          new Call(
		          new Ref($factorial_id),
		          new FlatSymbolTable(
			          [
				          'num' => new SubOp(new Ref($num), new Integer(1)),
			          ])
	          )
	)
);

// Define our main program.
$prog = new Prog();

// Define the factorial function.
$prog[] = new Def($factorial_id, $factorial);

// Now let's calculate some factorials.
$prog[] = new Outln(
	[
		"5! = ",
		new Call(new Ref($factorial_id),
		         new FlatSymbolTable(['num' => new Integer(5)]))
	]
);

$prog[] = new Outln(
	[
		"15! = ",
		new Call(new Ref($factorial_id),
		         new FlatSymbolTable(['num' => new Integer(15)]))
	]
);

// Print the program.
print "Program:\n";
print "--------------------\n";
print "$prog\n";
print "--------------------\n";


//
// Now let's run it.
//

// This will be used as a simple symbol table for the program.
$st = new FlatSymbolTable();
print "Output:\n";
print "--------------------\n";
print $prog->evaluate($st);
print "--------------------\n";
