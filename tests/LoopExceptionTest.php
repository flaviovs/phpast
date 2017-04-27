<?php

use PHPAST\LoopException;
use PHPAST\Integer;
use PHPAST\UnderflowException;

class LoopExceptionTest extends PHPUnit\Framework\TestCase {

	public function testGetBlocks() {
		$blocks = $this->createMock(Integer::class);
		$ex = new LoopException($blocks);
		$this->assertSame($blocks, $ex->getBlocks());
	}

	public function testAdvance() {
		$ex = new LoopException(new Integer(3));
		$this->assertFalse($ex->current());
		$ex->advance(); // 3=>2
		$this->assertFalse($ex->current());
		$ex->advance(); // 2=>1
		$this->assertTrue($ex->current());
		$this->expectException(UnderflowException::class);
		$ex->advance(); // 1=>0
	}
}
