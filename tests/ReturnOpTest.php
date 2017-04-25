<?php

use PHPAST\Literal;
use PHPAST\ReturnOp;
use PHPAST\ReturnException;

class ReturnOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new ReturnOp($this->createMock(Literal::class), $label);
	}

	public function testEvaluate() {
		$ret = $this->createMock(Literal::class);
		$ret
			->method('evaluate')
			->willReturn($ret);

		$op = new ReturnOp($ret);
		try {
			$op->evaluate($this->getMockSymbolTable());
		} catch (ReturnException $ex) {
			$this->assertSame($ret, $ex->getLiteral());
			return;
		}
		$this->fail('ReturnException not thrown');
	}
}
