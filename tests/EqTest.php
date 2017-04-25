<?php

use PHPAST\Node;
use PHPAST\Eq;
use PHPAST\Integer;

class EqTest extends NodeTest {

	public function createNode($label = NULL) {
		return new Eq($this->createMock(Node::class),
		                 $this->createMock(Node::class),
		                 $label);
	}

	public function testEvaluateTrue() {
		$op = new Eq(new Integer(2), new Integer(2));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertTrue((boolean)(string)$res);
	}

	public function testEvaluateFalse() {
		$op = new Eq(new Integer(1), new Integer(2));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertFalse((boolean)(string)$res);
	}

	public function testToString() {
		$op = new Eq(new Integer(1), new Integer(2));
		$this->assertEquals("(1 = 2)", (string)$op);
	}
}
