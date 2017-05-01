<?php

namespace PHPAST;

class DivOp extends ArithBinaryOp {

	public function evaluate(SymbolTable $st) {
		$lit1 = $this->node1->evaluate($st);
		$lit2 = $this->node2->evaluate($st);

		$denom = $lit2->getValue();
		if ($denom == 0) {
			throw new DivisionByZeroException($this->label,
			                                  "Division by zero");
		}

		return $this->arithPromote($lit1->getValue() / $denom, $lit1, $lit2);
	}

	public function __toString() {
		return '(' . $this->node1 . ' / ' . $this->node2 . ')';
	}
}
