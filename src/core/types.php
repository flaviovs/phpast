<?php

namespace PHPAST;

interface SymbolTable extends \ArrayAccess {}

interface LiteralFactory {
	public function create($mixed, $label = NULL);
}

class Identifier extends Node {
	protected $value;

	public function __construct($value, $label = NULL) {
		parent::__construct($label);
		$this->value = $value;
	}

	public function evaluate(SymbolTable $st) {
		return $this;
	}

	public function __toString() {
		return (string)$this->value;
	}
}

class Literal extends Identifier {}

class Number extends Literal {}
class Integer extends Number {}
class Float extends Number {}
class Boolean extends Literal {
	public function repr() {
		return $this->value ? 'TRUE' : 'FALSE';
	}
}
class Null_ extends Literal {
	static protected $null_;

	public function repr() {
		return 'NULL';
	}

	static public function get() {
		if (!static::$null_) {
			static::$null_ = new static(NULL);
		}
		return static::$null_;
	}
}

class String extends Literal {
	public function repr() {
		return '"' . addcslashes($this->value, "\0..\37!@\177..\377") . '"';
	}
}
