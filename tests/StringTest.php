<?php

use PHPAST\String;

class StringTest extends NumberTest {

	public function createNode($label = NULL) {
		return new String(TRUE, $label);
	}

	public function testRepr() {
		$node = new String('abc');
		$this->assertEquals('"abc"', $node->repr());
	}

	public function escapedStringsDataProvider() {
		// WATCH OUT! In some test tuples the first element ("expected") is
		// specified using single-quotes (thus no string escapes are
		// interpreted), whereas the second element (actual node string) is
		// specified using double-quotes, so they get translated by PHP.
		return [
			['', ''],
			['a\n\f\t\vb', "a\n\f\t\vb"],
			['a\000b', "a\000b"],
			['a b', 'a b'],
			['a!b', 'a!b'],
			['0', '0'],
			['a\\\b', 'a\b'],
			['a\\"b', 'a"b'],
		];
	}

	/**
	 * @dataProvider escapedStringsDataProvider
	 */
	public function testReprEscape($expected, $string) {
		$node = new String($string);
		// Note: the '"' (double-quotes) doesn't need to be in the
		// 'expected' parameter.
		$this->assertEquals('"' . $expected . '"', $node->repr());
	}
}
