<?php

use PHPAST\ArgList;

class ArgListTestCase extends PHPUnit\Framework\TestCase {
	public function testConstructor() {
		$al = new ArgList(['foo', 'bar']);

		$this->assertEquals(['foo', 'bar'],
		                    $al->getArrayCopy());
	}

	public function testConstructorDefaults() {
		$al = new ArgList(['foo', 'bar'], ['foo' => 1]);

		$this->assertEquals(['foo' => 1], $al->getDefaults());
	}
}
