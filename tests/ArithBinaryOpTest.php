<?php

use PHPAST\Node;
use PHPAST\Integer;
use PHPAST\Float;
use PHPAST\ArithBinaryOp;
use PHPAST\SymbolTable;

class ArithBinaryOpTestHelper extends ArithBinaryOp {
	public function evaluate(SymbolTable $st) {}
}

class ArithBinaryOpTest extends NodeTest {

	/**
	 * Standard NodeTest node creation
	 */
	public function createNode($label = NULL) {
		return new ArithBinaryOpTestHelper($this->createMock(Node::class),
		                                   $this->createMock(Node::class),
		                                   $label);
	}

	public function testPromoteWithInts() {
		$op = $this->createNode();
		$int1 = $this->createMock(Integer::class);
		$int2 = $this->createMock(Integer::class);

		$this->assertInstanceOf(Integer::class,
		                        $op->arithPromote(1, $int1, $int2));
	}

	public function testPromoteWithFloats() {
		$op = $this->createNode();
		$float1 = $this->createMock(Float::class);
		$float2 = $this->createMock(Float::class);

		$this->assertInstanceOf(Float::class,
		                        $op->arithPromote(1, $float1, $float2));
	}

	public function testPromoteWithIntFloat() {
		$op = $this->createNode();
		$int = $this->createMock(Integer::class);
		$float = $this->createMock(Float::class);

		$this->assertInstanceOf(Float::class,
		                        $op->arithPromote(1, $int, $float));
		$this->assertInstanceOf(Float::class,
		                        $op->arithPromote(1, $float, $int));
	}
}
