<?php

use PHPAST\Integer;
use PHPAST\BreakOp;
use PHPAST\BreakException;

class BreakOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new BreakOp(NULL, $label);
	}

	public function testEvaluate() {
		$ret = $this->createMock(Integer::class);
		$ret
			->method('evaluate')
			->willReturn($ret);

		$op = new BreakOp($ret);
		try {
			$op->evaluate($this->getMockSymbolTable());
		} catch (BreakException $ex) {
			$this->assertSame($ret, $ex->getBlocks());
			return;
		}
		$this->fail('BreakException not thrown');
	}
}
