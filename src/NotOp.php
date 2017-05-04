<?php

namespace PHPAST;

class NotOp extends UnaryOp {

	public function evaluate(SymbolTable $st) {
		return new Boolean(!(bool)$this->node->evaluate($st)->getValue());
	}

	public function __toString() {
		return '(!' . $this->node . ')';
	}
}
