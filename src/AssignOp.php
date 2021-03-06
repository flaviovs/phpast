<?php

namespace PHPAST;

class AssignOp extends Node {
	protected $ref;
	protected $value;

	public function __construct(Node $ref, Node $value, $label = NULL) {
		parent::__construct($label);
		$this->ref = $ref;
		$this->value = $value;
	}

	public function evaluate(SymbolTable $st) {
		// FIXME: check for symboltable exception and rethrow with our
		// label.
		$this->checkType($this->ref, Ref::class);
		return $this->ref->assign($st, $this->value->evaluate($st));
	}

	public function __toString() {
		return $this->ref . ' := ' . $this->value;
	}

	public function getRef() {
		return $this->ref;
	}

	public function getValueNode() {
		return $this->value;
	}
}
