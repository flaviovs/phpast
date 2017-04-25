<?php

use PHPAST\Out;

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
}
