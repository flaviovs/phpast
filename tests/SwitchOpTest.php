<?php

use PHPAST\Node;
use PHPAST\SwitchOp;
use PHPAST\Null_;

class SwitchOpTest extends NodeTest {

	/**
	 * Standard NodeTest node creation
	 */
	public function createNode($label = NULL) {
		return new SwitchOp($this->getMockLiteral(1),
		                    [],
		                    [],
		                    $label);
	}

	public function testBasicSwitch() {
		$node1 = $this->createMock(Node::class);
		$node2 = $this->createMock(Node::class);
		$node3 = $this->createMock(Node::class);

		$val = $this->createMock(Node::class);

		$node1
			->expects($this->never())
			->method('evaluate');

		$node2
			->expects($this->once())
			->method('evaluate')
			->willReturn($val);

		$node3
			->expects($this->never())
			->method('evaluate');

		$sw = new SwitchOp($this->getMockLiteral(2),
		                   [
			                   $this->getMockLiteral(1),
			                   $this->getMockLiteral(2),
			                   $this->getMockLiteral(3),
		                   ],
		                   [
			                   $node1,
			                   $node2,
			                   $node3,
		                   ]);

		$res = $sw->evaluate($this->getMockSymbolTable());
		$this->assertSame($val, $res);
	}

}
