<?php

use PHPAST\Node;
use PHPAST\MulOp;
use PHPAST\Integer;

class MulOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new MulOp($this->createMock(Node::class),
		                 $this->createMock(Node::class),
		                 $label);
	}

	public function testEvaluate() {
		$op = new MulOp(new Integer(2), new Integer(2));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertEquals(4, (string)$res);
	}

	public function testToString() {
		$op = new MulOp(new Integer(2), new Integer(3));
		$this->assertEquals("(2 * 3)", (string)$op);
	}
}
