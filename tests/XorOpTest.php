<?php

use PHPAST\XorOp;
use PHPAST\Boolean;

class XorOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new XorOp($this->getMockLiteral(TRUE),
		                 $this->getMockLiteral(TRUE),
		                 $label);
	}

	public function testEvaluateReturnsBoolean() {
		$op = new XorOp($this->getMockLiteral(TRUE),
		                $this->getMockLiteral(TRUE));
		$this->assertInstanceOf(Boolean::class,
		                        $op->evaluate($this->getMockSymbolTable()));
	}

	public function testEvaluateTrueTrue() {
		$op = new XorOp($this->getMockLiteral(TRUE),
		                $this->getMockLiteral(TRUE));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertFalse($res->getValue());
	}

	public function testEvaluateTrueFalse() {
		$op = new XorOp($this->getMockLiteral(TRUE),
		                $this->getMockLiteral(FALSE));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertTrue($res->getValue());
	}

	public function testEvaluateFalseTrue() {
		$op = new XorOp($this->getMockLiteral(FALSE),
		                $this->getMockLiteral(TRUE));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertTrue($res->getValue());
	}

	public function testEvaluateFalseFalse() {
		$op = new XorOp($this->getMockLiteral(FALSE),
		                $this->getMockLiteral(FALSE));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertFalse($res->getValue());
	}

	public function testToString() {
		$op = new XorOp($this->getMockLiteral(TRUE),
		                $this->getMockLiteral(TRUE));
		$this->assertEquals("(TRUE >< TRUE)", (string)$op);
	}
}
