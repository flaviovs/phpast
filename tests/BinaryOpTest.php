<?php

use PHPAST\Node;
use PHPAST\BinaryOp;
use PHPAST\SymbolTable;
use PHPAST\Null_;

class BinaryOpTestHelper extends BinaryOp {
	public function evaluate(SymbolTable $st) {
		return Null_::get();
	}
}

class BinaryOpTest extends NodeTest {

	/**
	 * Standard NodeTest node creation
	 */
	public function createNode($label = NULL) {
		return new BinaryOpTestHelper($this->createMock(Node::class),
		                              $this->createMock(Node::class),
		                              $label);
	}
}
