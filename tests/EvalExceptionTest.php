<?php

use PHPAST\EvalException;

class EvalExceptionTest extends PHPUnit\Framework\TestCase {

	public function testGetLiteral() {
		$ex = new EvalException("label");
		$this->assertEquals("label", $ex->getLabel());
	}
}
