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

class String extends Literal {
	public function repr() {
		return '"' . addcslashes($this->value,"\0..\37\42\134\177..\377") . '"';
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

class VList extends Literal implements \ArrayAccess, \IteratorAggregate {

	public function __construct(array $value = [], $label = NULL) {
		parent::__construct([], $label);
		foreach ($value as $k => $v) {
			$this[$k] = $v;
		}
	}

	public function __toString() {
		return '[' . implode(",", $this->value) . ']';
	}

	public function offsetSet($offset, $value) {
		if (!($value instanceof Node)) {
			throw new TypeException($this->label, 'Not a Node');
		}
		if ($offset === NULL) {
			$this->value[] = $value;
		} else {
			$this->value[$offset] = $value;
		}
	}

	public function offsetGet($offset) {
		if (!$this->offsetExists($offset)) {
			throw new NameException($this->label, "Invalid offset: $offset");
		}
		return $this->value[$offset];
	}

	public function offsetExists($offset) {
		return array_key_exists($offset, $this->value);
	}

	public function offsetUnset($offset) {
		unset($this->value[$offset]);
	}

	public function getIterator() {
		return new \ArrayIterator($this->value);
	}

	public function length() {
		return count($this->value);
	}
}
