<?php

use PHPAST\Node;
use PHPAST\Integer;
use PHPAST\Float;
use PHPAST\Boolean;
use PHPAST\String;
use PHPAST\Null_;
use PHPAST\Identifier;
use PHPAST\SymbolTable;

class NodeTestHelper extends Node {
	public function evaluate(SymbolTable $st) {}
}

class NodeTest extends PHPUnit\Framework\TestCase {

	public function createNode($label = NULL) {
		return new NodeTestHelper($label);
	}

	protected function getMockIdentifier($name) {
		$mock = $this->createMock(Identifier::class);
		$mock
			->method('evaluate')
			->willReturn($mock);
		$mock
			->method('getValue')
			->willReturn($name);
		$mock
			->method('__toString')
			->willReturn($name);
		return $mock;
	}

	protected function getMockLiteral($ret = NULL) {
		$type = gettype($ret);

		$str = (string)$ret;
		switch ($type) {
		case 'boolean':
			$lit = $this->createMock(Boolean::class);
			$str = $ret ? 'TRUE' : 'FALSE';
			break;

		case 'integer':
			$lit = $this->createMock(Integer::class);
			break;

		case 'double':
			$lit = $this->createMock(Float::class);
			break;

		case 'string':
			$lit = $this->createMock(String::class);
			$str = '"' . addslashes($ret) . '"';
			break;

		case 'NULL':
			$lit = $this->createMock(Null_::class);
			$str = 'NULL';
			break;

		default:
			throw new \RuntimeException($type);
		}

		$lit
			->method('evaluate')
			->willReturn($lit);

		$lit
			->method('getValue')
			->willReturn($ret);

		$lit
			->method('__toString')
			->willReturn($str);

		return $lit;
	}

	protected function getMockSymbolTable(array &$values = []) {
		$builder = $this->getMockBuilder(SymbolTable::class);
		$builder->setMethods([
			                     'offsetGet',
			                     'offsetSet',
			                     'offsetExists',
			                     'offsetUnset',
			                     'getArrayCopy',
		                     ]);
		$st = $builder->getMock();
		$st->expects($this->any())
			->method('offsetGet')
			->will($this->returnCallback(
				       function ($key) use (&$values) {
					       return $values[$key];
				       })
			);
		$st->expects($this->any())
			->method('offsetSet')
			->will($this->returnCallback(
				       function ($key, $val) use (&$values) {
					       $values[$key] = $val;
				       })
			);
		$st->expects($this->any())
			->method('offsetExists')
			->will($this->returnCallback(
				       function ($key) use (&$values) {
					       return array_key_exists($key, $values);
				       })
			);
		$st->expects($this->any())
			->method('offsetUnset')
			->will($this->returnCallback(
				       function ($key) use (&$values) {
					       unset($values[$key]);
				       })
			);

		$st->method('getArrayCopy')
			->willReturn($values);
		return $st;
	}

	public function testNodeWithoutLabel() {
		$node = $this->createNode();
		$this->assertNull($node->getLabel());
	}

	public function testNodeWithLabel() {
		$label = uniqid("test label ");
		$node = $this->createNode($label);
		$this->assertEquals($label, $node->getLabel());
	}
}
