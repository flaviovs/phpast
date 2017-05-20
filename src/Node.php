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

	protected function checkType(Node $node, $class, $message = NULL) {
		if (!($node instanceof $class)) {
			if (!$message) {
				// Remove our namespace prefix from the class, if any.
				$class = preg_replace('~^' . preg_quote(__NAMESPACE__) . '\\\~',
				                      '', $class);
				$message = "Expecting $class, got " . get_class($node);
			}
			throw new TypeException($this->label, $message);
		}
	}
}
