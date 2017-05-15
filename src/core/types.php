<?php

namespace PHPAST;

interface SymbolTable extends \ArrayAccess {}

interface LiteralFactory {
	public function create($mixed, $label = NULL);
}

class Value extends Node {
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

	public function getValue() {
		return $this->value;
	}
}

class Identifier extends Value {}

class Literal extends Value {}

class Number extends Literal {}
class Integer extends Number {}
class Float extends Number {
	static protected $nan;
	static protected $inf;

	static public function getNan() {
		if (static::$nan === NULL) {
			static::$nan = new self(NAN);
		}
		return static::$nan;
	}

	static public function getInf() {
		if (static::$inf === NULL) {
			static::$inf = new self(INF);
		}
		return static::$inf;
	}

	public function __toString() {
		return (is_nan($this->value)
		        ? 'NaN'
		        : (is_infinite($this->value)
		           ? 'Inf'
		           : parent::__toString()));
	}
}

class Boolean extends Literal {
	static protected $true;
	static protected $false;

	public function __toString() {
		return $this->value ? 'TRUE' : 'FALSE';
	}

	static public function getTrue() {
		if (static::$true === NULL) {
			static::$true = new Boolean(TRUE);
		}
		return static::$true;
	}

	static public function getFalse() {
		if (static::$false === NULL) {
			static::$false = new Boolean(FALSE);
		}
		return static::$false;
	}
}

class String extends Literal {
	public function __toString() {
		return '"' . addcslashes($this->value,"\0..\37\42\134\177..\377") . '"';
	}
}

class Null_ extends Literal {
	static protected $null_;

	public function __toString() {
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
