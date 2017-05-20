<?php

use PHPAST\Identifier;
use PHPAST\Ref;
use PHPAST\Node;
use PHPAST\TypeException;

class RefTest extends NodeTest {

	public function createNode($label = NULL) {
		return new Ref($this->getMockIdentifier('foo'), $label);
	}

	public function testEvaluateReturnsNode() {
		/* Nothing to evaluate, since testEvaluate() (see below) will make
		 * sure that Ref() always return the symbol table entry, which must be
		 * a Node already. */
		$this->assertTrue(TRUE);
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

	public function testGetIdentifier() {
		$id = $this->getMockIdentifier('foo');
		$ref = new Ref($id);
		$this->assertSame($id, $ref->getIdentifier());
	}

	public function testTypeCheck() {
		$bad = $this->createMock(Identifier::class);
		// Our bad node will return a node (not an identifier), so the Ref
		// object should compain.
		$bad
			->method('evaluate')
			->willReturn($this->createMock(Node::class));
		$ref = new Ref($bad);
		$this->expectException(TypeException::class);
		$ref->evaluate($this->getMockSymbolTable());
	}
}
