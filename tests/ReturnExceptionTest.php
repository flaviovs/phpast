<?php

use PHPAST\ReturnException;
use PHPAST\Literal;

class ReturnExceptionTest extends PHPUnit\Framework\TestCase {

	public function testGetLiteral() {
		$lit = $this->createMock(Literal::class);
		$ex = new ReturnException($lit);
		$this->assertSame($lit, $ex->getLiteral());
	}
}
