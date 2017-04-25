<?php

use PHPAST\Node;
use PHPAST\ForeachOp;
use PHPAST\VList;
use PHPAST\Ref;
use PHPAST\Identifier;

class ForeachOpTest extends NodeTest {

	/**
	 * Standard NodeTest node creation
	 */
	public function createNode($label = NULL) {
		return new ForeachOp($this->createMock(Ref::class),
		                     $this->createMock(Ref::class),
		                     $this->createMock(Ref::class),
		                     $this->createMock(Node::class),
		                     $label);
	}

	public function testEvaluate() {
		$table = [];
		$st = $this->getMockSymbolTable($table);

		$n1 = $this->createMock(Node::class);
		$n2 = $this->createMock(Node::class);

		$table['list'] = new VList(['n1' => $n1, 'n2' => $n2]);

		$k = new Ref(new Identifier('k'));
		$v = new Ref(new Identifier('v'));

		$node = $this->createMock(Node::class);
		$keys = [];
		$values = [];
		$node
			->method('evaluate')
			->will($this->returnCallback(
				       function ($st) use (&$table, &$keys, &$values) {
					       $keys[] = $table['k'];
					       $values[] = $table['v'];;
				       }));

		$op = new ForeachOp(new Ref(new Identifier('list')),
		                    $k, $v,
		                    $node);
		$op->evaluate($st);

		$this->assertEquals(['n1', 'n2'], $keys);
		$this->assertEquals([$n1, $n2], $values);
	}

}
