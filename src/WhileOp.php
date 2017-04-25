<?php

namespace PHPAST;

class WhileOp extends Node {
	protected $cond;
	protected $node;

	public function __construct(Node $cond, Node $node, $label = NULL) {
		parent::__construct($label);
		$this->cond = $cond;
		$this->node = $node;
	}

	public function evaluate(SymbolTable $st) {
		$res = Null_::get();
		while ((string)$this->cond->evaluate($st)) {
			$res = $this->node->evaluate($st);
		}
		return $res;
	}

	public function __toString() {
		return 'While ' . $this->cond . "\n\t"
			. str_replace("\n", "\n\t", $this->node);
	}
}
