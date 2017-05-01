<?php

use PHPAST\LeOp;
use PHPAST\Boolean;

class LeOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new LeOp($this->getMockLiteral(TRUE),
		                $this->getMockLiteral(TRUE),
		                $label);
	}

	public function testEvaluateReturnsBoolean() {
		$op = new LeOp($this->getMockLiteral(TRUE),
		               $this->getMockLiteral(TRUE));
		$this->assertInstanceOf(Boolean::class,
		                        $op->evaluate($this->getMockSymbolTable()));
	}

	public function testEvaluateTrue() {
		$op = new LeOp($this->getMockLiteral(2), $this->getMockLiteral(2));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertTrue($res->getValue());

		$op = new LeOp($this->getMockLiteral(1), $this->getMockLiteral(2));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertTrue($res->getValue());
	}

	public function testEvaluateFalse() {
		$op = new LeOp($this->getMockLiteral(2), $this->getMockLiteral(1));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertFalse($res->getValue());
	}

	public function testToString() {
		$op = new LeOp($this->getMockLiteral(1), $this->getMockLiteral(2));
		$this->assertEquals("(1 <= 2)", (string)$op);
	}
}
