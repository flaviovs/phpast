<?php

namespace PHPAST;

class MulOp extends ArithBinaryOp {

	public function evaluate(SymbolTable $st) {
		$lit1 = $this->node1->evaluate($st);
		$lit2 = $this->node2->evaluate($st);

		return $this->arithPromote((string)$lit1 * (string)$lit2, $lit1, $lit2);
	}

	public function __toString() {
		return '(' . $this->node1->repr() . ' * ' . $this->node2->repr() . ')';
	}
}
