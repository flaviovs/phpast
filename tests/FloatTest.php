<?php

use PHPAST\Float;

class FloatTest extends NumberTest {

	public function createNode($label = NULL) {
		return new Float(3.14, $label);
	}
}
