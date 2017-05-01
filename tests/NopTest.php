<?php

use PHPAST\Nop;
use PHPAST\Null_;

class NopTest extends NodeTest {

	public function createNode($label = NULL) {
		return new Nop($label);
	}

	public function testToString() {
		$nop = new Nop();
		$this->assertEquals('Nop', (string)$nop);
	}

	public function testEvaluate() {
		$nop = new Nop();
		$table = [];
		$res = $nop->evaluate($this->getMockSymbolTable($table));
		$this->assertSame(Null_::get(), $res);
		$this->assertEquals([], $table);
	}

	public function testSingleInstance() {
		$n1 = Nop::get();
		$n2 = Nop::get();
		$this->assertSame($n1, $n2);
	}

}
