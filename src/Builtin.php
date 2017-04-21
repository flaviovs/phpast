<?php

namespace PHPAST;

class Builtin extends Node {
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
					$arg = $fac->create($arg, $label);
				}
				return $arg;
			}, $args);
	}

	public function evaluate(SymbolTable $st) {
		$res = call_user_func_array($this->func,
									array_map(function(Node $n) {
											return $n->repr();
										}, $this->args));;
		if (!($res instanceof Node)) {
			$res = $this->fac->create($res, $this->label);
		}
		return $res;
	}

	protected function argsToString() {
		return implode(", ",
		               array_map(function($a) {
				               return $a->repr();
			               }, $this->args));
	}

	public function __toString() {
		return "<builtin \"$this->func\">(" . $this->argsToString() . ")";
	}
}
