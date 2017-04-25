<?php

use PHPAST\Builtin;

class BuiltTest extends NodeTest {

	public function createNode($label = NULL) {
		return new Builtin('foo', [], NULL, $label);
	}

	public function testEvaluate() {
		$b = new Builtin("pow", [3, 5]);
		$res = $b->evaluate($this->getMockSymbolTable());
		$this->assertEquals(pow(3, 5), (string)$res);
	}

	public function testToString() {
		$b = new Builtin("pow", [3, 5]);
		$this->assertEquals("<builtin \"pow\">(3, 5)", (string)$b);
	}

}
