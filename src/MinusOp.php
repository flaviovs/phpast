<?php

namespace PHPAST;

class MinusOp extends ArithUnaryOp {
	public function evaluate(SymbolTable $st) {
		$lit = $this->node->evaluate($st);

		return $this->arithPromote(-($lit->getValue()), $lit);
	}

	public function __toString() {
		return '(-' . $this->node . ')';
	}
}
