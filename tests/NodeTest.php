<?php

use PHPAST\Node;
use PHPAST\Literal;
use PHPAST\SymbolTable;

class NodeTestHelper extends Node {
	public function evaluate(SymbolTable $st) {}
}

class NodeTest extends PHPUnit\Framework\TestCase {

	public function createNode($label = NULL) {
		return new NodeTestHelper($label);
	}

	protected function getMockLiteral($ret = NULL) {
//		$builder = $this->getMockBuilder(Literal::class);
//		$builder->setMethods(['__toString']);
//		$lit = $builder->getMock();

		$lit = $this->createMock(Literal::class);
		$ret = $ret ?: $lit;
		$lit
			->method('evaluate')
			->willReturn($ret);
		// As of PHP 5.6, PHPUnit will bail if the cast is done inside the
		// willReturn() call.
		$sret = (string)$ret;
		$lit
			->method('__toString')
			->willReturn($sret);
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

	public function testRepr() {
		$node = $this->createNode();
		$this->assertEquals((string)$node, $node->repr());
	}

}
