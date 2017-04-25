<?php

use PHPAST\Def;
use PHPAST\Func;

class DefTest extends NodeTest {
	public function createNode($label = NULL) {
		return new Def('foo', $this->createMock(Func::class), $label);
	}

	public function testEvaluate() {
		$table = [];
		$st = $this->getMockSymbolTable($table);

		$func = $this->createMock(Func::class);

		$def = new Def('foo', $func);

		$def->evaluate($st);

		$this->assertEquals(['foo' => $func], $table);
	}
}
