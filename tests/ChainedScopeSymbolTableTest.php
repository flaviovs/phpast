<?php

use PHPAST\ChainedScopeSymbolTable;
use PHPAST\FlatSymbolTable;
use PHPAST\NameException;
use PHPAST\Node;

class ChainedScopeSymbolTableTest extends PHPUnit\Framework\TestCase {

	public function testOffsetGetReturnParentIfUnset() {
		$parent = new FlatSymbolTable();

		$st = new ChainedScopeSymbolTable([], $parent);

		$parent['foo'] = $node = $this->createMock(Node::class);

		$this->assertSame($st['foo'], $node);
	}

	public function testOffsetGetReturnLocalIfSet() {
		$parent = new FlatSymbolTable();

		$st = new ChainedScopeSymbolTable([], $parent);

		$parent['foo'] = $this->createMock(Node::class);

		$st['foo'] = $node = $this->createMock(Node::class);

		$this->assertSame($st['foo'], $node);
	}

	public function testOffsetSetSetsLocal() {
		$parent = new FlatSymbolTable();

		$st = new ChainedScopeSymbolTable([], $parent);

		$st['foo'] = $node = $this->createMock(Node::class);

		$this->assertSame($node, $st['foo']);

		$this->expectException(NameException::class);
		$parent['foo'];
	}
}
