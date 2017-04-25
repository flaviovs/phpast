<?php

use PHPAST\Boolean;

class BooleanTest extends NumberTest {

	public function createNode($label = NULL) {
		return new Boolean(TRUE, $label);
	}

	public function testRepr() {
		$node = new Boolean(TRUE);
		$this->assertEquals('TRUE', $node->repr());
		$node = new Boolean(FALSE);
		$this->assertEquals('FALSE', $node->repr());
	}
}
