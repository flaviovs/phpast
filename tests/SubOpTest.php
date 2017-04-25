<?php

use PHPAST\Node;
use PHPAST\SubOp;
use PHPAST\Integer;

class SubOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new SubOp($this->createMock(Node::class),
		                 $this->createMock(Node::class),
		                 $label);
	}

	public function testEvaluate() {
		$op = new SubOp(new Integer(1), new Integer(2));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertEquals(-1, (string)$res);
	}

	public function testToString() {
		$op = new SubOp(new Integer(1), new Integer(2));
		$this->assertEquals("(1 - 2)", (string)$op);
	}
}
