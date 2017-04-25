<?php

use PHPAST\Number;

class NumberTest extends LiteralTest {

	public function createNode($label = NULL) {
		return new Number(1, $label);
	}
}
