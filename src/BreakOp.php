<?php

namespace PHPAST;

class BreakOp extends Node {
	protected $val;

	public function __construct(Node $val = NULL, $label = NULL) {
		parent::__construct($label);
		$this->val = $val;
	}

	public function evaluate(SymbolTable $st) {
		throw new BreakException($this->val
		                         ? $this->val->evaluate($st)
		                         : NULL);
	}

	public function __toString() {
		$out = 'Break';
		if ($this->val) {
			$out .= ' ' . $this->val->repr();
		}
		return $out;
	}
}
