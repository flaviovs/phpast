<?php

namespace PHPAST;

class ForOp extends Node {
	protected $pre;
	protected $cond;
	protected $post;
	protected $node;

	public function __construct(Node $pre, Node $cond, Node $post,
	                            Node $node, $label = NULL) {
		parent::__construct($label);
		$this->pre = $pre;
		$this->cond = $cond;
		$this->post = $post;
		$this->node = $node;
	}

	public function evaluate(SymbolTable $st) {

		$res = Null_::get();
		for ($this->pre->evaluate($st);
		     (string)$this->cond->evaluate($st);
		     $this->post->evaluate($st)) {
			$res = $this->node->evaluate($st);
		}
		return $res;
	}

	public function __toString() {
		return 'For (' . $this->pre
			. '; ' . $this->cond
			. '; ' . $this->post . ")\n"
			. str_replace("\n", "\n\t", $this->node);
	}
}
