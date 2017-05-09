<?php

use PHPAST\AddOp;
use PHPAST\Integer;

class AddOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new AddOp($this->getMockLiteral(1),
		                 $this->getMockLiteral(1),
		                 $label);
	}

	public function testEvaluate() {
		$op = new AddOp($this->getMockLiteral(1), $this->getMockLiteral(2));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertEquals(3, (string)$res);
	}

	public function testToString() {
		$op = new AddOp($this->getMockLiteral(1), $this->getMockLiteral(2));
		$this->assertEquals("(1 + 2)", (string)$op);
	}
}
