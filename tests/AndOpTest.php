<?php

use PHPAST\AndOp;
use PHPAST\Boolean;

class AndOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new AndOp($this->getMockLiteral(TRUE),
		                 $this->getMockLiteral(TRUE),
		                 $label);
	}

	public function testEvaluateReturnsBoolean() {
		$op = new AndOp($this->getMockLiteral(TRUE),
		                $this->getMockLiteral(TRUE));
		$this->assertInstanceOf(Boolean::class,
		                        $op->evaluate($this->getMockSymbolTable()));
	}

	public function testEvaluateTrueTrue() {
		$op = new AndOp($this->getMockLiteral(TRUE),
		                $this->getMockLiteral(TRUE));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertTrue($res->getValue());
	}

	public function testEvaluateTrueFalse() {
		$op = new AndOp($this->getMockLiteral(TRUE),
		                $this->getMockLiteral(FALSE));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertFalse($res->getValue());
	}

	public function testEvaluateFalseTrue() {
		$op = new AndOp($this->getMockLiteral(FALSE),
		                $this->getMockLiteral(TRUE));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertFalse($res->getValue());
	}

	public function testEvaluateFalseFalse() {
		$op = new AndOp($this->getMockLiteral(FALSE),
		                $this->getMockLiteral(FALSE));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertFalse($res->getValue());
	}

	public function testShortCirtuit() {
		$false = $this->getMockLiteral(FALSE);
		$other = $this->getMockLiteral();

		// "Other" node should not be evaluated, since the first operand already
		// evaluates to FALSE.
		$other
			->expects($this->never())
			->method('evaluate');

		$op = new AndOp($false, $other);
		$op->evaluate($this->getMockSymbolTable());
	}

	public function testToString() {
		$op = new AndOp($this->getMockLiteral(TRUE),
		                $this->getMockLiteral(TRUE));
		$this->assertEquals("(TRUE && TRUE)", (string)$op);
	}
}
