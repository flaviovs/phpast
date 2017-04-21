<?php

namespace PHPAST;

class DivOp extends ArithBinaryOp {

	public function evaluate(SymbolTable $st) {
		$lit1 = $this->node1->evaluate($st);
		$lit2 = $this->node2->evaluate($st);

		if ((string)$lit2 == 0) {
			throw new DivisionByZeroException();
		}

		return $this->arithPromote((string)$lit1 / (string)$lit2, $lit1, $lit2);
	}

	public function __toString() {
		return '(' . $this->node1->repr() . ' / ' . $this->node2->repr() . ')';
	}
}
