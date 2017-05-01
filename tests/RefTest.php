<?php

use PHPAST\Identifier;
use PHPAST\Ref;
use PHPAST\Node;

class RefTest extends NodeTest {

	public function createNode($label = NULL) {
		return new Ref($this->getMockIdentifier('foo'), $label);
	}

	public function testEvaluate() {
		$id = $this->getMockIdentifier('foo');
		$ref = new Ref($id);

		$node = $this->createMock(Node::class);
		$table = ['foo' => $node];

		$res = $ref->evaluate($this->getMockSymbolTable($table));

		$this->assertSame($node, $res);
	}

	public function testToString() {
		$id = $this->getMockIdentifier('foo');
		$op = new Ref($id);
		$this->assertEquals("foo", (string)$op);
	}

	public function testAssign() {
		$id = $this->getMockIdentifier('foo');
		$ref = new Ref($id);

		$table = ['foo' => $this->createMock(Node::class)];

		$node = $this->createMock(Node::class);

		$res = $ref->assign($this->getMockSymbolTable($table), $node);

		$this->assertSame($node, $res);
	}
}
