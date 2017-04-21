<?php

namespace PHPAST;

class MinusOp extends ArithUnaryOp {
	public function evaluate(SymbolTable $st) {
		$lit = $this->node->evaluate($st);

		return $this->arithPromote(-((string)$lit), $lit);
	}

	public function __toString() {
		return '(-' . $this->node . ')';
	}
}
