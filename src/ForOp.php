<?php

namespace PHPAST;

class ForOp extends WhileOp {
	protected $pre;
	protected $prog;

	public function __construct(Node $pre, Node $cond, Node $post,
	                            Node $node, $label = NULL) {
		// This will be our for body. Notice that the body of the loop is
		// Prog, which gets the post code appended so that it will run last
		// at every loop.
		$this->prog = new Prog([$node, $post]);
		parent::__construct($cond, $this->prog, $label);
		$this->pre = $pre;
	}

	public function evaluate(SymbolTable $st) {
		$this->pre->evaluate($st);
		return parent::evaluate($st);
	}

	public function __toString() {
		return 'For (' . $this->pre
			. '; ' . $this->cond
			. '; ' . $this->prog[1] . ")\n\t"
			. str_replace("\n", "\n\t", $this->prog[0]);
	}
}
