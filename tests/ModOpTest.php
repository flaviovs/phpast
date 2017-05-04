<?php

use PHPAST\ModOp;
use PHPAST\Integer;

class ModOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new ModOp($this->getMockLiteral(1),
		                 $this->getMockLiteral(1),
		                 $label);
	}

	public function testEvaluateReturnsInteger() {
		$op = new ModOp($this->getMockLiteral(2), $this->getMockLiteral(1));
		$this->assertInstanceOf(Integer::class,
		                        $op->evaluate($this->getMockSymbolTable()));
	}

	public function testEvaluate() {
		$op = new ModOp($this->getMockLiteral(10), $this->getMockLiteral(4));
		$res = $op->evaluate($this->getMockSymbolTable());
		$this->assertEquals(2, $res->getValue());
	}

	public function testToString() {
		$op = new ModOp($this->getMockLiteral(1), $this->getMockLiteral(2));
		$this->assertEquals("(1 % 2)", (string)$op);
	}
}
