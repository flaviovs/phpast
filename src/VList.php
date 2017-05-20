<?php

namespace PHPAST;

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
