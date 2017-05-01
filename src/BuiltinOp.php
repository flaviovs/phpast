<?php

namespace PHPAST;

class BuiltinOp extends Node {
	protected $func;
	protected $args;
	protected $fac;

	protected static $literal_fac;

	public function __construct($func, array $args,
	                            LiteralFactory $fac = NULL, $label = NULL) {
		parent::__construct($label);
		$this->func = $func;

		if (!$fac) {
			if (!static::$literal_fac) {
				static::$literal_fac = new PHPLiteralFactory();
			}
			$fac = static::$literal_fac;
		}
		$this->fac = $fac;

		$this->args = array_map(function($arg) use ($fac, $label) {
				if (!($arg instanceof Node)) {
					// FIXME: check exception, rethrow with our label.
					$arg = $fac->create($arg, $label);
				}
				return $arg;
			}, $args);
	}

	public function evaluate(SymbolTable $st) {
		$res = call_user_func_array($this->func,
		                            array_map(function(Node $n) {
				                            return $n->getValue();
			                            }, $this->args));
		if (!($res instanceof Node)) {
			// FIXME: check exception, rethrow with our label.
			$res = $this->fac->create($res, $this->label);
		}
		return $res;
	}

	protected function argsToString() {
		return implode(", ", $this->args);
	}

	public function __toString() {
		return "<builtin \"$this->func\">(" . $this->argsToString() . ")";
	}
}
