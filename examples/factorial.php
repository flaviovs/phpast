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
$factorial[] = new IfOp(new LtOp(new Ref($num), new Integer(1)),
                        new ReturnOp(new Integer(0)));
$factorial[] = new IfOp(new EqOp(new Ref($num), new Integer(1)),
                        new ReturnOp(new Integer(1)));

$factorial[] = new ReturnOp(
	new MulOp(new Ref($num),
	          new CallOp(
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
$prog[] = new DefOp($factorial_id, $factorial);

// Now let's calculate some factorials.
$offset_ref = new Ref(new Identifier('offset'));
$value_ref = new Ref(new Identifier('value'));

$loop = new Outln(
	[
		$value_ref,
		" = ",
		new CallOp(new Ref($factorial_id),
		           new FlatSymbolTable(['num' => $value_ref]))
	]
);
$prog[] = new ForeachOp(new VList([
									  new Integer(0),
									  new Integer(1),
									  new Integer(5),
									  new Integer(10),
									  new Integer(15),
								  ]),
						$offset_ref, $value_ref, $loop);

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
$prog->evaluate($st);
print "--------------------\n";
