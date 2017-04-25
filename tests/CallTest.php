<?php

use PHPAST\Call;
use PHPAST\Ref;
use PHPAST\Func;
use PHPAST\ArgList;
use PHPAST\Identifier;
use PHPAST\Integer;
use PHPAST\ReturnException;

class CallTest extends NodeTest {
	public function createNode($label = NULL) {
		return new Call($this->createMock(Ref::class),
		                $this->getMockSymbolTable(),
		                $label);
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

		$call = new Call(new Ref(new Identifier('foo')),
		                 $this->getMockSymbolTable($args));

		$this->assertEquals(12345, (string)$call->evaluate($st));
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

		$call = new Call(new Ref(new Identifier('foo')),
		                 $this->getMockSymbolTable());

		$this->assertEquals(67890, (string)$call->evaluate($st));
	}
}