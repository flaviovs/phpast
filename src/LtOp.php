<?php

namespace PHPAST;

class LtOp extends BinaryOp {

	public function evaluate(SymbolTable $st) {
		return new Boolean($this->node1->evaluate($st)->getValue()
		                   < $this->node2->evaluate($st)->getValue());
	}

	public function __toString() {
		return '(' . $this->node1 . ' < ' . $this->node2 . ')';
	}
}
