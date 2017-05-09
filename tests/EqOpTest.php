<?php

use PHPAST\Node;
use PHPAST\EqOp;
use PHPAST\Integer;

class EqOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new EqOp($this->getMockLiteral(1),
		                $this->getMockLiteral(1),
		                $label);
	}

	public function testEvaluateTrue() {
		$op = new EqOp($this->getMockLiteral(2), $this->getMockLiteral(2));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertTrue($res->getValue());
	}

	public function testEvaluateFalse() {
		$op = new EqOp($this->getMockLiteral(1), $this->getMockLiteral(2));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertFalse($res->getValue());
	}

	public function testToString() {
		$op = new EqOp($this->getMockLiteral(1), $this->getMockLiteral(2));
		$this->assertEquals("(1 = 2)", (string)$op);
	}
}
