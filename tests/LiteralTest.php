<?php

use PHPAST\Literal;

class LiteralTest extends ValueWrapperTest {

	public function createNode($label = NULL) {
		return new Literal('test node', $label);
	}
}
