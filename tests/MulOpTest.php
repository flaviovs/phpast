<?php

use PHPAST\MulOp;
use PHPAST\Integer;

class MulOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new MulOp($this->getMockLiteral(1),
		                 $this->getMockLiteral(1),
		                 $label);
	}

	public function testEvaluate() {
		$op = new MulOp($this->getMockLiteral(2), $this->getMockLiteral(2));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertEquals(4, (string)$res);
	}

	public function testToString() {
		$op = new MulOp($this->getMockLiteral(2), $this->getMockLiteral(3));
		$this->assertEquals("(2 * 3)", (string)$op);
	}
}
