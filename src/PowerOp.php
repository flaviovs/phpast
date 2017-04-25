<?php

namespace PHPAST;

class PowerOp extends ArithBinaryOp {
	public function evaluate(SymbolTable $st) {
		$lit1 = $this->node1->evaluate($st);
		$lit2 = $this->node2->evaluate($st);

		$n1 = (string)$lit1;
		$n2 = (string)$lit2;

		return $this->arithPromote($n1 ** $n2, $lit1, $lit2);
	}

	public function __toString() {
		return '(' . $this->node1 . ' ** ' . $this->node2 . ')';
	}
}
