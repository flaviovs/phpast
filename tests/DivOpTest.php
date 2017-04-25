<?php

use PHPAST\Node;
use PHPAST\DivOp;
use PHPAST\Integer;
use PHPAST\DivisionByZeroException;

class DivOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new DivOp($this->createMock(Node::class),
		                 $this->createMock(Node::class),
		                 $label);
	}

	public function testEvaluate() {
		$op = new DivOp(new Integer(8), new Integer(2));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertEquals(4, (string)$res);
	}

	public function testToString() {
		$op = new DivOp(new Integer(2), new Integer(3));
		$this->assertEquals("(2 / 3)", (string)$op);
	}

	public function testZeroRaisesException() {
		$op = new DivOp(new Integer(2), new Integer(0));
		$this->expectException(DivisionByZeroException::class);
		$res = $op->evaluate($this->getMockSymbolTable());
	}
}
