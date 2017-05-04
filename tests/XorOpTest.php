<?php

use PHPAST\XorOp;
use PHPAST\Boolean;

class XorOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new XorOp($this->getMockLiteral(TRUE),
		                 $this->getMockLiteral(TRUE),
		                 $label);
	}

	public function testEvaluateTrueTrue() {
		$l1 = $this->getMockLiteral(TRUE);
		$l2 = $this->getMockLiteral(TRUE);
		$op = new XorOp($l1, $l2);
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertSame(Boolean::getFalse(), $res);
	}

	public function testEvaluateTrueFalse() {
		$l1 = $this->getMockLiteral(TRUE);
		$l2 = $this->getMockLiteral(FALSE);
		$op = new XorOp($l1, $l2);
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertSame($l1, $res);
	}

	public function testEvaluateFalseTrue() {
		$l1 = $this->getMockLiteral(FALSE);
		$l2 = $this->getMockLiteral(TRUE);
		$op = new XorOp($l1, $l2);
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertSame($l2, $res);
	}

	public function testEvaluateFalseFalse() {
		$l1 = $this->getMockLiteral(FALSE);
		$l2 = $this->getMockLiteral(FALSE);
		$op = new XorOp($l1, $l2);
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertSame(Boolean::getFalse(), $res);
	}

	public function testToString() {
		$op = new XorOp($this->getMockLiteral(TRUE),
		                $this->getMockLiteral(TRUE));
		$this->assertEquals("(TRUE >< TRUE)", (string)$op);
	}
}
