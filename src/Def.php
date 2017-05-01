<?php

namespace PHPAST;

class Def extends Node {
	protected $name;
	protected $func;

	public function __construct($name, Func $func, $label = NULL) {
		parent::__construct($label);
		$this->name = $name;
		$this->func = $func;
	}

	public function evaluate(SymbolTable $st) {
		$symbol = (string)$this->name;
		if (isset($st[$symbol])) {
			throw new NameError($this->label,
			                    "Symbol already exist: $symbol");
		}
		$st[$symbol] = $this->func;
	}

	public function __toString() {
		return "Def $this->name"
			. str_replace("\n", "\n\t", $this->func->repr());
	}
}
