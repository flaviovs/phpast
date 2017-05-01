<?php

namespace PHPAST;

class ReturnOp extends Node {
	protected $val;

	public function __construct(Node $val, $label = NULL) {
		parent::__construct($label);
		$this->val = $val;
	}

	public function evaluate(SymbolTable $st) {
		throw new ReturnException($this->val->evaluate($st));
	}

	public function __toString() {
		return 'Return ' . $this->val;
	}
}
