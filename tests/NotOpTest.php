<?php

use PHPAST\NotOp;
use PHPAST\Boolean;

class NotOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new NotOp($this->getMockLiteral(FALSE), $label);
	}

	public function testEvaluateReturnsBoolean() {
		$op = new NotOp($this->getMockLiteral(TRUE));
		$this->assertInstanceOf(Boolean::class,
		                        $op->evaluate($this->getMockSymbolTable()));
	}

	public function testEvaluateTrue() {
		$op = new NotOp($this->getMockLiteral(TRUE));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertFalse($res->getValue());
	}

	public function testEvaluateFalse() {
		$op = new NotOp($this->getMockLiteral(FALSE));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertTrue($res->getValue());
	}

	public function testToString() {
		$op = new NotOp($this->getMockLiteral(TRUE),
		                $this->getMockLiteral(TRUE));
		$this->assertEquals("(!TRUE)", (string)$op);
	}
}
