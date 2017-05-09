<?php

use PHPAST\Node;
use PHPAST\IfOp;
use PHPAST\Null_;
use PHPAST\Boolean;

class IfOpTest extends NodeTest {

	/**
	 * Standard NodeTest node creation
	 */
	public function createNode($label = NULL) {
		return new IfOp($this->getMockLiteral(TRUE),
		                $this->getMockLiteral(1),
		                $this->getMockLiteral(2),
		                $label);
	}

	protected function getMockTrue() {
		return $this->getMockLiteral(TRUE);
	}

	protected function getMockFalse() {
		return $this->getMockLiteral(FALSE);
	}

	public function testEvaluateTrue() {
		$true = $this->createMock(Node::class);
		$true
			->method('evaluate')
			->willReturn($this->getMockTrue());

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
			->willReturn($this->getMockFalse());

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
			->willReturn($this->getMockFalse());

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
