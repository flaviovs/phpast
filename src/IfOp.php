<?php

namespace PHPAST;

class IfOp extends Node {

	protected $cond;
	protected $nodet;
	protected $nodef;

	public function __construct(Node $cond, Node $nodet, Node $nodef = NULL,
	                            $label = NULL) {
		parent::__construct($label);
		$this->cond = $cond;
		$this->nodet = $nodet;
		$this->nodef = $nodef;
	}

	public function evaluate(SymbolTable $st) {
		if ($this->cond->evaluate($st)->getValue()) {
			return $this->nodet->evaluate($st);
		}
		if ($this->nodef) {
			return $this->nodef->evaluate($st);
		}
		return Null_::get();
	}

	public function __toString() {
		$out = "If " . $this->cond . " Then\n\t" .
			str_replace("\n", "\n\t", $this->nodet);
		if ($this->nodef) {
			$out .= "\nElse\n\t"
				. str_replace("\n", "\n\t", $this->nodef);
		}
		return $out;
	}
}
