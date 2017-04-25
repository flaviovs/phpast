<?php

use PHPAST\LoopException;
use PHPAST\Integer;

class LoopExceptionTest extends PHPUnit\Framework\TestCase {

	public function testGetBlocks() {
		$blocks = $this->createMock(Integer::class);
		$ex = new LoopException($blocks);
		$this->assertSame($blocks, $ex->getBlocks());
	}
}
