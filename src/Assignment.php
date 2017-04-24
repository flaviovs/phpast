<?php

namespace PHPAST;

class Assignment extends Node {
	protected $id;
	protected $value;

	public function __construct(Identifier $id, Node $value, $label = NULL) {
		parent::__construct($label);
		$this->id = $id;
		$this->value = $value;
	}

	public function evaluate(SymbolTable $st) {
		// FIXME: check for symboltable exception and rethrow with our
		// label.
		return ($st[$this->id->evaluate($st)->repr()] = $this->value->evaluate($st));
	}

	public function __toString() {
		return $this->id->repr() . ' := ' . $this->value;
	}
}
