<?php

use PHPAST\IncOp;
use PHPAST\Integer;
use PHPAST\Float;
use PHPAST\Ref;
use PHPAST\Node;

class IncOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new IncOp($this->createMock(Ref::class), 1, $label);
	}

	public function testEvaluateReturnsNode() {
		$table = ['foo' => new Integer(0)];
		$st = $this->getMockSymbolTable($table);

		$op = new IncOp(new Ref($this->getMockIdentifier('foo')), 5);

		$this->assertInstanceOf(Node::class, $op->evaluate($st));
	}

	public function testEvaluate() {
		$table = ['foo' => new Integer(0)];
		$st = $this->getMockSymbolTable($table);

		$op = new IncOp(new Ref($this->getMockIdentifier('foo')), 5);

		$op->evaluate($st);
		$this->assertInstanceOf(Integer::class, $table['foo']);
		$this->assertEquals(5, $table['foo']->getValue());

		$op->evaluate($st);
		$this->assertInstanceOf(Integer::class, $table['foo']);
		$this->assertEquals(10, $table['foo']->getValue());
	}

	public function testEvaluateDefault() {
		$table = ['foo' => new Integer(1)];
		$st = $this->getMockSymbolTable($table);

		$op = new IncOp(new Ref($this->getMockIdentifier('foo')));

		$op->evaluate($st);
		$this->assertInstanceOf(Integer::class, $table['foo']);
		$this->assertEquals(2, $table['foo']->getValue());
	}

	public function testEvaluateFloat() {
		$table = ['foo' => new Float(1)];
		$st = $this->getMockSymbolTable($table);

		$op = new IncOp(new Ref($this->getMockIdentifier('foo')));

		$op->evaluate($st);
		$this->assertInstanceOf(Float::class, $table['foo']);
	}

	public function testEvaluateReturnsLiteral() {
		$table = ['foo' => new Float(1)];
		$st = $this->getMockSymbolTable($table);

		$op = new IncOp(new Ref($this->getMockIdentifier('foo')));

		$res = $op->evaluate($st);
		$this->assertSame($table['foo'], $res);
	}

	public function testToString() {
		$op = new IncOp(new Ref($this->getMockIdentifier('foo')), 1234);
		$this->assertEquals("foo += 1234", (string)$op);
	}
}
