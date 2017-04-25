<?php

use PHPAST\Integer;

class IntegerTest extends NumberTest {

	public function createNode($label = NULL) {
		return new Integer(1, $label);
	}
}
