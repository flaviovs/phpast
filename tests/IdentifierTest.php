<?php

use PHPAST\Identifier;

class IdentifierTest extends NodeTest {

	public function createNode($label = NULL) {
		return new Identifier('test node', $label);
	}

	public function testEvaluate() {
		$node = $this->createNode();
		$this->assertSame($node,
		                  $node->evaluate($this->getMockSymbolTable()));
	}

	public function testToString() {
		$node = new Identifier('foo');
		$this->assertEquals('foo', (string)$node);
	}
}
