<?php

namespace PHPAST;

class OrOp extends BinaryOp {

	public function evaluate(SymbolTable $st) {
		return ($this->node1->evaluate($st)->getValue()
		        ? $this->node1
		        : ($this->node2->evaluate($st)->getValue()
		           ? $this->node2
		           : Boolean::getFalse()));
	}

	public function __toString() {
		return '(' . $this->node1 . ' || ' . $this->node2 . ')';
	}
}
