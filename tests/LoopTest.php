<?php

use PHPAST\Node;
use PHPAST\LoopOp;
use PHPAST\ContinueOp;
use PHPAST\BreakOp;
use PHPAST\BreakException;
use PHPAST\Prog;

class LoopOpTest extends NodeTest {

	/**
	 * Standard NodeTest node creation
	 */
	public function createNode($label = NULL) {
		return new LoopOp($this->createMock(Node::class),
		                  $label);
	}

	public function testContinue() {
		$i = 0;

		// This node increment the counter.
		$inc = $this->createMock(Node::class);
		$inc
			->method('evaluate')
			->will($this->returnCallback(function ($st) use (&$i) {
						$i++;
						// Protects against infinite loops.
						if ($i >= 5) {
							throw new BreakException();
						}
					}));

		// This node crashes the interpreter if evaluated.
		$crash = $this->createMock(Node::class);
		$crash
			->method('evaluate')
			->will($this->throwException(
				       new RuntimeException(
					       "This node should never be evaluated"
				       )));

		$prog = new Prog();
		$prog[] = $inc;
		$prog[] = new ContinueOp();
		$prog[] = $crash;

		$op = new LoopOp($prog);
		$op->evaluate($this->getMockSymbolTable());

		$this->assertEquals(5, $i);
	}

	public function testBreak() {
		$i = 0;

		// This node increment the counter.
		$inc = $this->createMock(Node::class);
		$inc
			->method('evaluate')
			->will($this->returnCallback(function ($st) use (&$i) {
						$i++;
					}));

		// This node crashes the interpreter if evaluated.
		$crash = $this->createMock(Node::class);
		$crash
			->method('evaluate')
			->will($this->throwException(
				       new RuntimeException(
					       "This node should never be evaluated"
				       )));

		$prog = new Prog();
		$prog[] = $inc;
		$prog[] = new BreakOp();
		$prog[] = $crash;

		$op = new LoopOp($prog);
		$op->evaluate($this->getMockSymbolTable());

		$this->assertEquals(1, $i);
	}
}
