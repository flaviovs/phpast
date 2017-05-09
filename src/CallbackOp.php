<?php

namespace PHPAST;

class CallbackOp extends Node {

	protected $callback;

	public function __construct(callable $callback, $label = NULL) {
		parent::__construct($label);
		$this->callback = $callback;
	}

	public function evaluate(SymbolTable $st) {
		$res = call_user_func($this->callback, $st);
		if (!($res instanceof Node)) {
			throw new TypeException($this->label,
			                        get_class($this)
			                        . " should return a Node, not "
			                        . gettype($res));
		}
		return $res;
	}

	public function __toString() {
		return '<callback>()';
	}
}
