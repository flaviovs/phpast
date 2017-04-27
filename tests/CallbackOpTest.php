<?php

use PHPAST\CallbackOp;

class CallbackOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new CallbackOp(function() {}, $label);
	}

	public function testEvaluate() {
		$calls = 0;

		$cb = new CallbackOp(function() use (&$calls) { $calls++; });
		$cb->evaluate($this->getMockSymbolTable());

		$this->assertEquals(1, $calls);
	}

	public function testEvaluatePassSymbolTable() {
		$st = $this->getMockSymbolTable();
		$passed_st = NULL;

		$cb = new CallbackOp(function($eval_st) use (&$passed_st) {
				$passed_st = $eval_st;
			});
		$cb->evaluate($st);

		$this->assertSame($st, $passed_st);
	}
}
