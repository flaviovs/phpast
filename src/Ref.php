<?php

namespace PHPAST;

class Ref extends Node {
	protected $name;

	public function __construct(Identifier $name, $label = NULL) {
		parent::__construct($label);
		$this->name = $name;
	}

	public function evaluate(SymbolTable $st) {
		return $st[(string)$this->name->evaluate($st)];
	}

	public function assign(SymbolTable $st, Node $value) {
		return ($st[$this->repr()] = $value);
	}

	public function __toString() {
		return $this->name->repr();
	}
}
