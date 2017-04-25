<?php

use PHPAST\Node;
use PHPAST\PowerOp;
use PHPAST\Integer;

class PowerOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new PowerOp($this->createMock(Node::class),
		                   $this->createMock(Node::class),
		                   $label);
	}

	public function testEvaluate() {
		$op = new PowerOp(new Integer(2), new Integer(3));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertEquals(8, (string)$res);
	}

	public function testToString() {
		$op = new PowerOp(new Integer(1), new Integer(2));
		$this->assertEquals("(1 ** 2)", (string)$op);
	}
}
