<?php

use PHPAST\OrOp;
use PHPAST\Boolean;

class OrOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new OrOp($this->getMockLiteral(TRUE),
		                $this->getMockLiteral(TRUE),
		                $label);
	}

	public function testEvaluateReturnsBoolean() {
		$op = new OrOp($this->getMockLiteral(TRUE),
		               $this->getMockLiteral(TRUE));
		$this->assertInstanceOf(Boolean::class,
		                        $op->evaluate($this->getMockSymbolTable()));
	}

	public function testEvaluateTrueTrue() {
		$op = new OrOp($this->getMockLiteral(TRUE),
		               $this->getMockLiteral(TRUE));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertTrue($res->getValue());
	}

	public function testEvaluateTrueFalse() {
		$op = new OrOp($this->getMockLiteral(TRUE),
		               $this->getMockLiteral(FALSE));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertTrue($res->getValue());
	}

	public function testEvaluateFalseTrue() {
		$op = new OrOp($this->getMockLiteral(FALSE),
		               $this->getMockLiteral(TRUE));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertTrue($res->getValue());
	}

	public function testEvaluateFalseFalse() {
		$op = new OrOp($this->getMockLiteral(FALSE),
		               $this->getMockLiteral(FALSE));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertFalse($res->getValue());
	}

	public function testShortCirtuit() {
		$false = $this->getMockLiteral(TRUE);
		$other = $this->getMockLiteral();

		// "Other" node should not be evaluated, since the first operand
		// already evaluates to TRUE.
		$other
			->expects($this->never())
			->method('evaluate');

		$op = new OrOp($false, $other);
		$op->evaluate($this->getMockSymbolTable());
	}

	public function testToString() {
		$op = new OrOp($this->getMockLiteral(TRUE),
		                $this->getMockLiteral(TRUE));
		$this->assertEquals("(TRUE || TRUE)", (string)$op);
	}
}
