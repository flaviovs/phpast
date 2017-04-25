<?php

use PHPAST\Identifier;
use PHPAST\Ref;
use PHPAST\Node;

class RefTest extends NodeTest {

	public function createNode($label = NULL) {
		$id = $this->createMock(Identifier::class);
		$id
			->method('repr')
			->willReturn((string)$id);
		return new Ref($id, $label);
	}

	public function testEvaluate() {
		$id = $this->createMock(Identifier::class);
		$id
			->method('evaluate')
			->willReturn('foo');

		$ref = new Ref($id);

		$node = $this->createMock(Node::class);
		$table = ['foo' => $node];

		$res = $ref->evaluate($this->getMockSymbolTable($table));

		$this->assertSame($node, $res);
	}

	public function testToString() {
		$id = $this->createMock(Identifier::class);
		$id
			->method('repr')
			->willReturn('foo');
		$op = new Ref($id);
		$this->assertEquals("foo", (string)$op);
	}
}
