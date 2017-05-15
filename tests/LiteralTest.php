<?php

use PHPAST\Literal;

class LiteralTest extends ValueTest {

	public function createNode($label = NULL) {
		return new Literal('test node', $label);
	}
}
