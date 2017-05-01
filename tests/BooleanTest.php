<?php

use PHPAST\Boolean;

class BooleanTest extends NumberTest {

	public function createNode($label = NULL) {
		return new Boolean(TRUE, $label);
	}

	public function testToString() {
		$node = new Boolean(TRUE);
		$this->assertEquals('TRUE', (string)$node);
		$node = new Boolean(FALSE);
		$this->assertEquals('FALSE', (string)$node);
	}
}
