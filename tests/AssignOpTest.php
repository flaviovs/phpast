<?php

use PHPAST\AssignOp;
use PHPAST\Ref;
use PHPAST\Node;
use PHPAST\String;

class AssignOpTest extends NodeTest {

	public function createNode($label = NULL) {
		return new AssignOp($this->createMock(Ref::class),
		                    $this->createMock(Node::class),
		                    $label);
	}

	public function testEvaluate() {
		$storage = [];
		$st = $this->getMockSymbolTable($storage);
		$ass = new AssignOp(new Ref($this->getMockIdentifier('foo')),
		                    new String('zee'));
		$ass->evaluate($st);

		$this->assertEquals('zee', $storage['foo']->getValue());
	}
}
