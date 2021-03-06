<?php

use PHPAST\CallOp;
use PHPAST\Ref;
use PHPAST\Func;
use PHPAST\ArgList;
use PHPAST\Integer;
use PHPAST\ReturnException;
use PHPAST\Node;

class CallOpTest extends NodeTest {
	public function createNode($label = NULL) {
		return new CallOp($this->createMock(Ref::class),
		                  $this->getMockSymbolTable(),
		                  $label);
	}

	public function testEvaluateReturnsNode() {
		/* testEvaluate() (see below) will make check that the node is
		   returned. */
		$this->assertTrue(TRUE);
	}

	public function testEvaluate() {
		$table = [];
		$st = $this->getMockSymbolTable($table);

		$arglist = $this->createMock(ArgList::class);
		$arglist
			->method('getDefaults')
			->willReturn(['two' => new Integer(2)]);
		$arglist
			->method('getIterator')
			->willReturn(new \ArrayIterator(['one', 'two']));

		$func = $this->createMock(Func::class);
		$func
			->method('getArgList')
			->willReturn($arglist);

		$func
			->method('evaluate')
			->willReturn(new Integer(12345));

		$table['foo'] = $func;

		$args = ['one' => new Integer(1)];

		$call = new CallOp(new Ref($this->getMockIdentifier('foo')),
		                   $this->getMockSymbolTable($args));
		$res = $call->evaluate($st);

		$this->assertInstanceOf(Node::class, $res);
		$this->assertEquals(12345, $res->getValue());
	}

	public function testEvaluateReturn() {
		$table = [];
		$st = $this->getMockSymbolTable($table);

		$arglist = $this->createMock(ArgList::class);
		$arglist
			->method('getDefaults')
			->willReturn([]);
		$arglist
			->method('getIterator')
			->willReturn(new \ArrayIterator([]));

		$func = $this->createMock(Func::class);
		$func
			->method('getArgList')
			->willReturn($arglist);

		$func
			->method('evaluate')
			->will($this->throwException(new ReturnException(new Integer(67890))));

		$table['foo'] = $func;

		$call = new CallOp(new Ref($this->getMockIdentifier('foo')),
		                   $this->getMockSymbolTable());

		$this->assertEquals(67890, (string)$call->evaluate($st));
	}
}
