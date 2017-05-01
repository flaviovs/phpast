<?php

namespace PHPAST;

class ContinueOp extends Node {
	protected $val;

	public function __construct(Node $val = NULL, $label = NULL) {
		parent::__construct($label);
		$this->val = $val;
	}

	public function evaluate(SymbolTable $st) {
		throw new ContinueException($this->val
		                            ? $this->val->evaluate($st)
		                            : NULL);
	}

	public function __toString() {
		$out = 'Continue';
		if ($this->val) {
			$out .= ' ' . $this->val;
		}
		return $out;
	}
}
