<?php

namespace PHPAST;

abstract class Node {
	protected $label;

	abstract public function evaluate(SymbolTable $st);

	public function __construct($label = NULL) {
		$this->label = $label;
	}

	public function getLabel() {
		return $this->label;
	}

	public function __toString() {
		return '<' . get_class($this) . ' object>';
	}

	public function getValue() {
		throw new TypeException($this->label,
		                        get_class($this) . ' has no value');
	}
}
