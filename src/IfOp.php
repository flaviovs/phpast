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
		if ((string)$this->cond->evaluate($st)) {
			return $this->nodet->evaluate($st);
		}
		if ($this->nodef) {
			return $this->nodef->evaluate($st);
		}
		return Null_::get();
	}

	public function __toString() {
		$out = "If " . $this->cond->repr() . " Then\n" . $this->nodet->repr();
		if ($this->nodef) {
			$out .= "\nElse\n" . $this->nodef->repr();
		}
		return $out;
	}
}
