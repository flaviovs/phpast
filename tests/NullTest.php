<?php

use PHPAST\Null_;

class NullTest extends LiteralTest {

	public function createNode($label = NULL) {
		return new Null_(NULL, $label);
	}

	public function testRepr() {
		$node = new Null_(NULL);
		$this->assertEquals('NULL', $node->repr());
	}

	public function testSingleInstanceValue() {
		$n1 = Null_::get();
		$n2 = Null_::get();
		$this->assertSame($n1, $n2);
	}

}
