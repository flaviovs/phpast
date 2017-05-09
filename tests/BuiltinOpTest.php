<?php

use PHPAST\BuiltinOp;

class BuiltOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new BuiltinOp('sin', [1], NULL, $label);
	}

	public function testEvaluate() {
		$b = new BuiltinOp("pow", [3, 5]);
		$res = $b->evaluate($this->getMockSymbolTable());
		$this->assertEquals(pow(3, 5), (string)$res);
	}

	public function testToString() {
		$b = new BuiltinOp("pow", [3, 5]);
		$this->assertEquals("<builtin \"pow\">(3, 5)", (string)$b);
	}

}
