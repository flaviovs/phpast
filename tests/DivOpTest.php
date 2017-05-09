<?php

use PHPAST\DivOp;
use PHPAST\Integer;
use PHPAST\DivisionByZeroException;

class DivOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new DivOp($this->getMockLiteral(1),
		                 $this->getMockLiteral(1),
		                 $label);
	}

	public function testEvaluate() {
		$op = new DivOp($this->getMockLiteral(8), $this->getMockLiteral(2));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertEquals(4, (string)$res);
	}

	public function testToString() {
		$op = new DivOp($this->getMockLiteral(2), $this->getMockLiteral(3));
		$this->assertEquals("(2 / 3)", (string)$op);
	}

	public function testZeroRaisesException() {
		$op = new DivOp($this->getMockLiteral(2), $this->getMockLiteral(0));
		$this->expectException(DivisionByZeroException::class);
		$res = $op->evaluate($this->getMockSymbolTable());
	}
}
