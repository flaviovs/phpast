<?php

use PHPAST\MinusOp;
use PHPAST\Number;

class MinusOpTest extends ArithUnaryOpTest {

	public function createNode($label = NULL) {
		return new MinusOp($this->getMockLiteral(), $label);
	}

	public function testEvaluate() {
		$num = $this->createMock(Number::class);
		$num->method('evaluate')->willReturn($this->getMockLiteral(2));
		$op = new MinusOp($num);
		$this->assertEquals(-2,
		                    (string)$op->evaluate($this->getMockSymbolTable()));
	}
}
