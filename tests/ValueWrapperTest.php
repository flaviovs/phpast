<?php

use PHPAST\ValueWrapper;

class ValueWrapperTest extends NodeTest {

	public function createNode($label = NULL) {
		return new ValueWrapper('test node', $label);
	}

	public function testEvaluate() {
		$node = $this->createNode();
		$this->assertSame($node,
		                  $node->evaluate($this->getMockSymbolTable()));
	}

	public function testToString() {
		$node = new ValueWrapper('foo');
		$this->assertEquals('foo', (string)$node);
	}
}
