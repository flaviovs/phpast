<?php

namespace PHPAST;

class Prog extends Node implements \ArrayAccess, \IteratorAggregate {
	protected $nodes = [];

	public function __construct(array $nodes = [], $label = NULL) {
		parent::__construct($label);
		$this->nodes = $nodes;
	}

	public function evaluate(SymbolTable $st) {
		$ret = NULL;
		foreach ($this->nodes as $node) {
			$ret = $node->evaluate($st);
		}
		return $ret;
	}

	public function __toString() {
		return implode("\n", $this->nodes);
	}

	public function offsetSet($offset, $node) {
		if (!($node instanceof Node)) {
			throw new TypeException($this->label,
			                        get_class($this) . " only accepts nodes");
		}
		if ($offset === NULL) {
			$this->nodes[] = $node;
		} else {
			$this->nodes[$offset] = $node;
		}
	}

	public function offsetGet($offset) {
		return $this->nodes[$offset];
	}

	public function offsetUnset($offset) {
		unset($this->nodes[$offset]);
	}

	public function offsetExists($offset) {
		return array_key_exists($offset, $this->nodes);
	}

	public function getIterator() {
		return new \ArrayIterator($this->nodes);
    }

	public function count() {
		return count($this->nodes);
	}
}
