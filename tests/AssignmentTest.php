<?php

use PHPAST\Assignment;
use PHPAST\Ref;
use PHPAST\Identifier;
use PHPAST\Node;
use PHPAST\String;

class AssignmentTest extends NodeTest {

	public function createNode($label = NULL) {
		return new Assignment($this->createMock(Ref::class),
		                      $this->createMock(Node::class),
		                      $label);
	}

	public function testEvaluate() {
		$storage = [];
		$st = $this->getMockSymbolTable($storage);
		$ass = new Assignment(new Ref(new Identifier('foo')),
		                      new String('zee'));
		$ass->evaluate($st);

		$this->assertEquals('zee', $storage['foo']);
	}
}
