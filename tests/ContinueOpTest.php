<?php

use PHPAST\Integer;
use PHPAST\ContinueOp;
use PHPAST\ContinueException;

class ContinueOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new ContinueOp(NULL, $label);
	}

	public function testEvaluate() {
		$ret = $this->createMock(Integer::class);
		$ret
			->method('evaluate')
			->willReturn($ret);

		$op = new ContinueOp($ret);
		try {
			$op->evaluate($this->getMockSymbolTable());
		} catch (ContinueException $ex) {
			$this->assertSame($ret, $ex->getBlocks());
			return;
		}
		$this->fail('ContinueException not thrown');
	}
}
