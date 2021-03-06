<?php

use PHPAST\PowerOp;
use PHPAST\Integer;

class PowerOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new PowerOp($this->getMockLiteral(1),
		                   $this->getMockLiteral(2),
		                   $label);
	}

	public function testEvaluate() {
		$op = new PowerOp($this->getMockLiteral(2), $this->getMockLiteral(3));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertEquals(8, (string)$res);
	}

	public function testToString() {
		$op = new PowerOp($this->getMockLiteral(1), $this->getMockLiteral(2));
		$this->assertEquals("(1 ** 2)", (string)$op);
	}
}
