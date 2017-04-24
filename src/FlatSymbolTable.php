<?php

namespace PHPAST;

class FlatSymbolTable extends \ArrayObject implements SymbolTable {

	public function __construct($array = []) {
		parent::__construct();
		foreach ($array as $k => $v) {
			$this[$k] = $v;
		}
	}

	public function offsetSet($offset, $value) {
		if (!($value instanceof Node)) {
			throw new TypeException(NULL, "Not a node: $value");
		}
		parent::offsetSet($offset, $value);
	}

	public function offsetGet($offset) {
		if (!$this->offsetExists($offset)) {
			throw new NameException(NULL, "Unknown symbol: $offset");
		}
		return parent::offsetGet($offset);
	}

	public function __toString() {
		return var_export($this->getArrayCopy(), TRUE);
	}
}
