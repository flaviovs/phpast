<?php

namespace PHPAST;

class WhileOp extends LoopOp {
	protected $cond;

	public function __construct(Node $cond, Node $node, $label = NULL) {
		parent::__construct($node, $label);
		$this->cond = $cond;
	}

	public function evaluate(SymbolTable $st) {
		$res = Null_::get();
		while ((string)$this->cond->evaluate($st) && $this->loop($st, $res)) {
			// NOTHING
		}
		return $res;
	}

	public function __toString() {
		return 'While ' . $this->cond . "\n\t"
			. str_replace("\n", "\n\t", $this->node);
	}
}
