<?php

use PHPAST\Identifier;
use PHPAST\OffsetRef;
use PHPAST\Node;
use PHPAST\VList;

class OffsetRefTest extends NodeTest {

	public function createNode($label = NULL) {
		return new OffsetRef($this->createMock(VList::class),
		                     $this->getMockIdentifier('foo'),
		                     $label);
	}

	public function testEvaluate() {
		$n0 = $this->createMock(Node::class);
		$n1 = $this->createMock(Node::class);
		$vlist = new VList([$n0, $n1]);

		$offset0 = $this->createMock(Identifier::class);
		$offset0
			->method('evaluate')
			->willReturn(0);

		$oref = new OffsetRef($vlist, $offset0);

		$this->assertSame($n0,
		                  $oref->evaluate($this->getMockSymbolTable()));
	}

	public function testAssign() {
		$vlist = new VList();

		$offset0 = $this->createMock(Identifier::class);
		$offset0
			->method('evaluate')
			->willReturn(0);

		$oref = new OffsetRef($vlist, $offset0);

		$node = $this->createMock(Node::class);
		$oref->assign($this->getMockSymbolTable(), $node);

		$this->assertEquals([$node], $vlist->getIterator()->getArrayCopy());
	}
}
