<?php

use PHPAST\Node;
use PHPAST\ForOp;

class ForOpTest extends NodeTest {

	/**
	 * Standard NodeTest node creation
	 */
	public function createNode($label = NULL) {
		return new ForOp($this->createMock(Node::class),
		                $this->createMock(Node::class),
		                $this->createMock(Node::class),
		                $this->createMock(Node::class),
		                $label);
	}

	public function testEvaluate() {
		$pre = $this->createMock(ForOp::class);
		$cond = $this->createMock(ForOp::class);
		$post = $this->createMock(ForOp::class);
		$node = $this->createMock(ForOp::class);

		$i = NULL;

		$pre
			->method('evaluate')
			->will($this->returnCallback(function() use (&$i) {
						$i = 0;
					}));
		$cond
			->method('evaluate')
			->will($this->returnCallback(function() use (&$i) {
						return $i < 10;
					}));
		$post
			->method('evaluate')
			->will($this->returnCallback(function() use (&$i) {
						$i++;
					}));

		$calls = [];
		$node
			->expects($this->exactly(10))
			->method('evaluate')
			->will($this->returnCallback(function ($st) use (&$i, &$calls) {
						$calls[] = $i;
					}));

		$op = new ForOp($pre, $cond, $post, $node);
		$op->evaluate($this->getMockSymbolTable());

		$this->assertEquals([0, 1, 2, 3, 4, 5, 6, 7, 8, 9], $calls);
	}
}