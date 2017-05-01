<?php

use PHPAST\Node;
use PHPAST\WhileOp;
use PHPAST\ContinueOp;
use PHPAST\BreakOp;
use PHPAST\Prog;

class WhileOpTest extends NodeTest {

	/**
	 * Standard NodeTest node creation
	 */
	public function createNode($label = NULL) {
		return new WhileOp($this->createMock(Node::class),
		                   $this->createMock(Node::class),
		                   $label);
	}

	public function testEvaluate() {
		$cond = $this->createMock(Node::class);
		$node = $this->createMock(Node::class);

		$i = 0;

		$that = $this;

		$cond
			->method('evaluate')
			->will($this->returnCallback(function() use (&$i, $that) {
						return $that->getMockLiteral($i < 10);
					}));

		$calls = [];
		$node
			->expects($this->exactly(10))
			->method('evaluate')
			->will($this->returnCallback(function ($st) use (&$i, &$calls) {
						$calls[] = $i;
						$i++;
					}));

		$op = new WhileOp($cond, $node);
		$op->evaluate($this->getMockSymbolTable());

		$this->assertEquals([0, 1, 2, 3, 4, 5, 6, 7, 8, 9], $calls);
	}
}
