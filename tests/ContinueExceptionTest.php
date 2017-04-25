<?php

use PHPAST\ContinueException;
use PHPAST\Integer;

class ContinueExceptionTest extends PHPUnit\Framework\TestCase {

	public function testGetBlocks() {
		$blocks = $this->createMock(Integer::class);
		$ex = new ContinueException($blocks);
		$this->assertSame($blocks, $ex->getBlocks());
	}
}
