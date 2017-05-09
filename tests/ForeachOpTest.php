<?php

use PHPAST\Node;
use PHPAST\ForeachOp;
use PHPAST\VList;
use PHPAST\Ref;
use PHPAST\Prog;
use PHPAST\ContinueOp;
use PHPAST\BreakOp;

class ForeachOpTest extends NodeTest {

	/**
	 * Standard NodeTest node creation
	 */
	public function createNode($label = NULL) {
		return new ForeachOp($this->createMock(VList::class),
		                     $this->createMock(Ref::class),
		                     $this->createMock(Ref::class),
		                     $this->createMock(Node::class),
		                     $label);
	}

	public function testEvaluateReturnsNode() {
		// Already covered in testEvaluate() below
		$this->assertTrue(TRUE);
	}

	public function testEvaluate() {
		$table = [];
		$st = $this->getMockSymbolTable($table);

		$n1 = $this->createMock(Node::class);
		$n2 = $this->createMock(Node::class);

		$vlist = new VList(['n1' => $n1, 'n2' => $n2]);

		$k = new Ref($this->getMockIdentifier('k'));
		$v = new Ref($this->getMockIdentifier('v'));

		$node = $this->createMock(Node::class);
		$keys = [];
		$values = [];
		$node
			->method('evaluate')
			->will($this->returnCallback(
				       function ($st) use (&$table, &$keys, &$values) {
					       $keys[] = $table['k'];
					       $values[] = $table['v'];
				       }));

		$op = new ForeachOp($vlist, $k, $v, $node);
		$res = $op->evaluate($st);

		$this->assertEquals(['n1', 'n2'], $keys);
		$this->assertEquals([$n1, $n2], $values);

		$this->assertInstanceOf(Node::class, $res);
	}

}
