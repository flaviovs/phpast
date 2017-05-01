<?php

use PHPAST\LtOp;
use PHPAST\Boolean;

class LtOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new LtOp($this->getMockLiteral(2),
		                $this->getMockLiteral(1),
		                $label);
	}

	public function testEvaluateReturnsBoolean() {
		$op = new LtOp($this->getMockLiteral(2), $this->getMockLiteral(1));
		$this->assertInstanceOf(Boolean::class,
		                        $op->evaluate($this->getMockSymbolTable()));
	}
	public function testEvaluateTrue() {
		$op = new LtOp($this->getMockLiteral(1), $this->getMockLiteral(2));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertTrue($res->getValue());
	}

	public function testEvaluateFalse() {
		$op = new LtOp($this->getMockLiteral(2), $this->getMockLiteral(1));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertFalse($res->getValue());

		$op = new LtOp($this->getMockLiteral(2), $this->getMockLiteral(2));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertFalse($res->getValue());
	}

	public function testToString() {
		$op = new LtOp($this->getMockLiteral(1), $this->getMockLiteral(2));
		$this->assertEquals("(1 < 2)", (string)$op);
	}
}
