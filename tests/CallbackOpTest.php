<?php

use PHPAST\CallbackOp;

class CallbackOpTest extends NodeTest {

	public function createNode($label = NULL) {
		$lit = $this->getMockLiteral();
		return new CallbackOp(function() use ($lit) { return $lit; }, $label);
	}

	public function testEvaluate() {
		$calls = 0;

		$lit = $this->getMockLiteral();
		$cb = new CallbackOp(function() use (&$calls, $lit) {
				$calls++;
				return $lit;
			});
		$cb->evaluate($this->getMockSymbolTable());

		$this->assertEquals(1, $calls);
	}

	public function testEvaluatePassSymbolTable() {
		$st = $this->getMockSymbolTable();
		$passed_st = NULL;

		$lit = $this->getMockLiteral();
		$cb = new CallbackOp(function($eval_st) use (&$passed_st, $lit) {
				$passed_st = $eval_st;
				return $lit;
			});
		$cb->evaluate($st);

		$this->assertSame($st, $passed_st);
	}
}
