<?php

use PHPAST\FlatSymbolTable;
use PHPAST\NameException;
use PHPAST\TypeException;
use PHPAST\Node;

class FlatSymbolTableTest extends PHPUnit\Framework\TestCase {

	public function testOffsetGetSet() {
		$st = new FlatSymbolTable();

		$st['foo'] = $node = $this->createMock(Node::class);
		$this->assertSame($node, $st['foo']);
	}

	public function testOffsetSetCheckInstance() {
		$st = new FlatSymbolTable();
		$this->expectException(TypeException::class);
		$st['foo'] = 'bar';
	}

	public function testInvalidSymbolRaisesException() {
		$st = new FlatSymbolTable();
		$this->expectException(NameException::class);
		$st['foo'];
	}
}
