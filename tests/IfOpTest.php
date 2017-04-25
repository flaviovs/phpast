<?php

use PHPAST\Node;
use PHPAST\IfOp;
use PHPAST\Null_;

class IfOpTest extends NodeTest {

	/**
	 * Standard NodeTest node creation
	 */
	public function createNode($label = NULL) {
		return new IfOp($this->createMock(Node::class),
		                $this->createMock(Node::class),
		                $this->createMock(Node::class),
		                $label);
	}

	public function testEvaluateTrue() {
		$true = $this->createMock(Node::class);
		$true
			->method('evaluate')
			->willReturn(1);

		$nodet = $this->createMock(Node::class);
		$nodet
			->expects($this->once())
			->method('evaluate')
			->willReturn('true');
		$nodef = $this->createMock(Node::class);
		$nodef
			->expects($this->never())
			->method('evaluate')
			->willReturn('false');

		$ifop = new IfOp($true, $nodet, $nodef);

		$this->assertEquals('true',
		                    $ifop->evaluate($this->getMockSymbolTable()));
	}

	public function testEvaluateFalse() {
		$false = $this->createMock(Node::class);
		$false
			->method('evaluate')
			->willReturn(0);

		$nodet = $this->createMock(Node::class);
		$nodet
			->expects($this->never())
			->method('evaluate')
			->willReturn('true');
		$nodef = $this->createMock(Node::class);
		$nodef
			->expects($this->once())
			->method('evaluate')
			->willReturn('false');

		$ifop = new IfOp($false, $nodet, $nodef);

		$this->assertEquals('false',
		                    $ifop->evaluate($this->getMockSymbolTable()));
	}

	public function testEvaluateNoFalseReturnsNull() {
		$false = $this->createMock(Node::class);
		$false
			->method('evaluate')
			->willReturn(0);

		$nodet = $this->createMock(Node::class);
		$nodet
			->expects($this->never())
			->method('evaluate')
			->willReturn('true');

		$ifop = new IfOp($false, $nodet);

		$this->assertSame(Null_::get(),
		                  $ifop->evaluate($this->getMockSymbolTable()));
	}
}
