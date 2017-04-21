<?php

namespace PHPAST;

class Eq extends BinaryOp {

	public function evaluate(SymbolTable $st) {
		return (string)$this->node1->evaluate($st) == (string)$this->node2->evaluate($st);
	}

	public function __toString() {
		return '(' . $this->node1->repr() . ' = ' . $this->node2->repr() . ')';
	}
}
