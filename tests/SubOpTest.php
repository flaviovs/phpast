<?php

use PHPAST\SubOp;
use PHPAST\Integer;

class SubOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new SubOp($this->getMockLiteral(1),
		                 $this->getMockLiteral(1),
		                 $label);
	}

	public function testEvaluate() {
		$op = new SubOp($this->getMockLiteral(1), $this->getMockLiteral(2));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertEquals(-1, (string)$res);
	}

	public function testToString() {
		$op = new SubOp($this->getMockLiteral(1), $this->getMockLiteral(2));
		$this->assertEquals("(1 - 2)", (string)$op);
	}
}
