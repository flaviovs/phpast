<?php

use PHPAST\DefOp;
use PHPAST\Func;

class DefOpTest extends NodeTest {
	public function createNode($label = NULL) {
		return new DefOp('foo', $this->createMock(Func::class), $label);
	}

	public function testEvaluate() {
		$table = [];
		$st = $this->getMockSymbolTable($table);

		$func = $this->createMock(Func::class);

		$def = new DefOp('foo', $func);

		$def->evaluate($st);

		$this->assertEquals(['foo' => $func], $table);
	}
}
