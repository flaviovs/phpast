<?php

namespace PHPAST;

class IfOp extends Node {

	protected $cond;
	protected $then_;
	protected $else_;

	public function __construct(Node $cond, Node $then_, Node $else_ = NULL,
	                            $label = NULL) {
		parent::__construct($label);
		$this->cond = $cond;
		$this->then_ = $then_;
		$this->else_ = $else_;
	}

	public function evaluate(SymbolTable $st) {
		if ($this->cond->evaluate($st)->getValue()) {
			return $this->then_->evaluate($st);
		}
		if ($this->else_) {
			return $this->else_->evaluate($st);
		}
		return Null_::get();
	}

	public function __toString() {
		$out = "If " . $this->cond . " Then\n\t" .
			str_replace("\n", "\n\t", $this->then_);
		if ($this->else_) {
			$out .= "\nElse\n\t"
				. str_replace("\n", "\n\t", $this->else_);
		}
		return $out;
	}
}
