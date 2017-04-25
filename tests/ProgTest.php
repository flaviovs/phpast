<?php

use PHPAST\Prog;
use PHPAST\Node;

class ProgTest extends NodeTest {

	public function createNode($label = NULL) {
		return new Prog([], $label);
	}

	public function testEvaluate() {
		$node1 = $this->createMock(Node::class);
		$node2 = $this->createMock(Node::class);
		$node3 = $this->createMock(Node::class);

		// Make node's evaluate() methods return the (mock) object, so that
		// we can assert it afterward.
		$node1
			->expects($this->once())
			->method('evaluate')
			->willReturn($node1);
		$node2
			->expects($this->once())
			->method('evaluate')
			->willReturn($node2);
		$node3
			->expects($this->once())
			->method('evaluate')
			->willReturn($node3);

		$prog = new Prog([$node1, $node2, $node3]);

		$this->assertSame($node3,
		                  $prog->evaluate($this->getMockSymbolTable()));
	}

	public function testArrayAccess() {
		$n0 = $this->createMock(Node::class);
		$n1 = $this->createMock(Node::class);

		$prog = new Prog([$n0, $n1]);

		$prog[] = $n2 = $this->createMock(Node::class);
		$prog[3] = $n3 = $this->createMock(Node::class);
		$prog[] = $n4 = $this->createMock(Node::class);
		$prog[] = $n5 = $this->createMock(Node::class);

		// Replace node at pos 4
		$prog[4] = $n4repl = $this->createMock(Node::class);

		$this->assertEquals(
			[$n0, $n1, $n2, $n3, $n4repl, $n5],
			$prog->getIterator()->getArrayCopy());
	}
}
