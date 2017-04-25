<?php

namespace PHPAST;

class Assignment extends Node {
	protected $ref;
	protected $value;

	public function __construct(Ref $ref, Node $value, $label = NULL) {
		parent::__construct($label);
		$this->ref = $ref;
		$this->value = $value;
	}

	public function evaluate(SymbolTable $st) {
		// FIXME: check for symboltable exception and rethrow with our
		// label.
		return $this->ref->assign($st, $this->value->evaluate($st));
	}

	public function __toString() {
		return $this->ref->repr() . ' := ' . $this->value;
	}
}
