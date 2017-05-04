<?php

namespace PHPAST;

class IncOp extends UnaryOp {

	protected $val;

	public function __construct(Ref $ref, $val = 1, $label = NULL) {
		parent::__construct($ref, $label);
		$this->val = $val;
	}

	public function evaluate(SymbolTable $st) {
		$lit = $this->node->evaluate($st);
		$class = get_class($lit);

		return $this->node->assign($st,
		                           new $class($lit->getValue() + $this->val));
	}

	public function __toString() {
		return $this->node . ' += ' . $this->val;
	}
}
