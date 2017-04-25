<?php

use PHPAST\Outln;

class OutlnTest extends OutTest {

	public function createNode($label = NULL) {
		return new Outln([], NULL, $label);
	}

	public function testPrint() {
		$out = new Outln(["foo", "bar"]);
		ob_start();
		$out->evaluate($this->getMockSymbolTable());
		$output = ob_get_clean();
		$this->assertEquals("foobar" . PHP_EOL, $output);
	}
}
