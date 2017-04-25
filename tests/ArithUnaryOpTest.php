<?php

use PHPAST\Node;
use PHPAST\Integer;
use PHPAST\Float;
use PHPAST\ArithUnaryOp;
use PHPAST\SymbolTable;

class ArithUnaryOpTestHelper extends ArithUnaryOp {
	public function evaluate(SymbolTable $st) {}
}

class ArithUnaryOpTest extends NodeTest {

	/**
	 * Standard NodeTest node creation
	 */
	public function createNode($label = NULL) {
		return new ArithUnaryOpTestHelper($this->createMock(Node::class),
		                                  $label);
	}

	public function testPromoteWithInt() {
		$op = $this->createNode();
		$int = $this->createMock(Integer::class);

		$this->assertInstanceOf(Integer::class,  $op->arithPromote(1, $int));
	}

	public function testPromoteWithFloat () {
		$op = $this->createNode();
		$float  = $this->createMock(Float::class);

		$this->assertInstanceOf(Float::class, $op->arithPromote(1, $float));
	}
}
