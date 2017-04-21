<?php

namespace PHPAST;

class PowerOp extends BinaryOp {
	public function evaluate(SymbolTable $st) {
		$lit1 = $this->node1->evaluate($st);
		$lit2 = $this->node2->evaluate($st);

		assert('$lit1 instanceof Literal');
		assert('$lit2 instanceof Literal');

		return (string)$lit1 ** (string)$lit2;
	}

	public function __toString() {
		return '(' . $this->node1 . ' ** ' . $this->node2 . ')';
	}
}
