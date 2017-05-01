<?php

namespace PHPAST;

class SubOp extends ArithBinaryOp {

	public function evaluate(SymbolTable $st) {
		$lit1 = $this->node1->evaluate($st);
		$lit2 = $this->node2->evaluate($st);

		return $this->arithPromote($lit1->getValue() - $lit2->getValue(),
		                           $lit1, $lit2);
	}

	public function __toString() {
		return '(' . $this->node1 . ' - ' . $this->node2 . ')';
	}
}
