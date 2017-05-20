<?php

use PHPAST\VList;
use PHPAST\Node;
use PHPAST\NameException;
use PHPAST\TypeException;

class VListTest extends LiteralTest {

	public function createNode($label = NULL) {
		return new VList([], $label);
	}

	public function testEvaluate() {
		$node1 = $this->createMock(Node::class);
		$node2 = $this->createMock(Node::class);
		$node1
			->method('evaluate')
			->willReturn($node2);
		$l1 = new VList([$node1]);
		$l2 = $l1->evaluate($this->getMockSymbolTable());
		$this->assertSame([$node2],
		                  $l2->getIterator()->getArrayCopy());
	}

	public function testOffsetGet() {
		$n0 = $this->createMock(Node::class);
		$n1 = $this->createMock(Node::class);
		$n2 = $this->createMock(Node::class);
		$l = new VList([$n0, $n1, $n2]);

		$this->assertSame($n0, $l[0]);
		$this->assertSame($n1, $l[1]);
		$this->assertSame($n2, $l[2]);

		$this->expectException(NameException::class);
		$l[3];
	}

	public function testOffsetSetAcceptsOnlyNodes() {
		$l = new VList();
		$this->expectException(TypeException::class);
		$l[] = NULL;
	}

	public function testOffsetExists() {
		$l = new VList();
		$l['foo'] = $this->createMock(Node::class);
		$l[] = $this->createMock(Node::class);

		$this->assertArrayHasKey('foo', $l);
		$this->assertArrayHasKey(0, $l);

		$this->assertArrayNotHasKey('bar', $l);
		$this->assertArrayNotHasKey(1, $l);
	}

	public function testOffsetUnset() {
		$l = new VList();

		$l['foo'] = $this->createMock(Node::class);

		unset($l['foo']);
		$this->assertArrayNotHasKey('foo', $l);
	}

	public function testGetIterator() {
		$l = new VList();

		$l['foo'] = $node1 = $this->createMock(Node::class);
		$l['bar'] = $node2 = $this->createMock(Node::class);

		$this->assertEquals([
			                    'foo' => $node1,
			                    'bar' => $node2,
		                    ], $l->getIterator()->getArrayCopy());
	}
}
