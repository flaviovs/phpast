<?php

use PHPAST\Out;
use PHPAST\Null_;

class OutTest extends NodeTest {

	public function createNode($label = NULL) {
		return new Out([], NULL, $label);
	}

	public function testPrint() {
		$out = new Out(["foo", "bar"]);
		ob_start();
		$out->evaluate($this->getMockSymbolTable());
		$output = ob_get_clean();
		$this->assertEquals("foobar", $output);
	}

	public function testEvaluateReturnsNull() {
		$out = $this->createNode();
		ob_start();
		$res = $out->evaluate($this->getMockSymbolTable());
		ob_end_clean();
		$this->assertSame(Null_::get(), $res);
	}
}
