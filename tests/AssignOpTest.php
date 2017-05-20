<?php

use PHPAST\AssignOp;
use PHPAST\Ref;
use PHPAST\Node;
use PHPAST\String;
use PHPAST\TypeException;

class AssignOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new AssignOp($this->createMock(Ref::class),
		                    $this->createMock(Node::class),
		                    $label);
	}

	public function testEvaluateReturnsNode() {
		// Test condition checked in testEvaluate() below
		$this->assertTrue(TRUE);
	}

	public function testEvaluate() {
		$storage = [];
		$st = $this->getMockSymbolTable($storage);
		$val = new String('zee');
		$ass = new AssignOp(new Ref($this->getMockIdentifier('foo')), $val);
		$res = $ass->evaluate($st);

		$this->assertEquals('zee', $storage['foo']->getValue());

		// Ensure that assignment evaluates to value assigned
		$this->assertSame($val, $res);
	}

	public function testGetRef() {
		$ref = $this->createMock(Ref::class);
		$ass = new AssignOp($ref, $this->getMockLiteral());

		$this->assertSame($ref, $ass->getRef());
	}

	public function testGetValueNode() {
		$val = $this->getMockLiteral();
		$ass = new AssignOp($this->createMock(Ref::class), $val);

		$this->assertSame($val, $ass->getValueNode());
	}

	public function testCheckType() {
		$val = $this->getMockLiteral();
		$ass = new AssignOp($this->createMock(Node::class),
		                    $this->createMock(Node::class));
		$this->expectException(TypeException::class);
		$ass->evaluate($this->getMockSymbolTable());
	}
}
