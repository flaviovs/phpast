<?php

use PHPAST\Literal;

class LiteralTest extends IdentifierTest {

	public function createNode($label = NULL) {
		return new Literal('test node', $label);
	}
}
