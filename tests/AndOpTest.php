<?php

use PHPAST\AndOp;
use PHPAST\Boolean;

class AndOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new AndOp($this->getMockLiteral(TRUE),
		                 $this->getMockLiteral(TRUE),
		                 $label);
	}

	public function testEvaluateTrueTrue() {
		$l1 = $this->getMockLiteral(TRUE);
		$l2 = $this->getMockLiteral(TRUE);
		$op = new AndOp($l1, $l2);
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertSame($l2, $res);
	}

	public function testEvaluateTrueFalse() {
		$l1 = $this->getMockLiteral(TRUE);
		$l2 = $this->getMockLiteral(FALSE);
		$op = new AndOp($l1, $l2);
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertSame(Boolean::getFalse(), $res);
	}

	public function testEvaluateFalseTrue() {
		$l1 = $this->getMockLiteral(FALSE);
		$l2 = $this->getMockLiteral(TRUE);
		$op = new AndOp($l1, $l2);
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertSame(Boolean::getFalse(), $res);
	}

	public function testEvaluateFalseFalse() {
		$l1 = $this->getMockLiteral(FALSE);
		$l2 = $this->getMockLiteral(FALSE);
		$op = new AndOp($l1, $l2);
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertSame(Boolean::getFalse(), $res);
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
