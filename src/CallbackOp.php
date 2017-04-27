<?php

namespace PHPAST;

class CallbackOp extends Node {

	protected $callback;

	public function __construct(callable $callback, $label = NULL) {
		parent::__construct($label);
		$this->callback = $callback;
	}

	public function evaluate(SymbolTable $st) {
		return call_user_func($this->callback, $st);
	}

	public function __toString() {
		return '<callback>()';
	}
}
