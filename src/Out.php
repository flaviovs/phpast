<?php

namespace PHPAST;

class Out extends BuiltinOp {

	public function __construct(array $args,
	                            LiteralFactory $fac = NULL, $label = NULL) {
		parent::__construct('print', $args, $fac, $label);
	}

	public function evaluate(SymbolTable $st) {
		foreach ($this->args as $arg) {
			echo $arg->evaluate($st)->getValue();
		}
	}

	public function __toString() {
		// Get class name withour our namespace
		$class = preg_replace('/^' . preg_quote(__NAMESPACE__) . '\\\/',
		                      '',
		                      get_class($this));
		return "$class ". $this->argsToString();
	}
}
