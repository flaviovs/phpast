<?php

namespace PHPAST;

class ArgList extends \ArrayObject {

	public function __construct(array $args, array $defaults = []) {
		parent::__construct($args);
		$this->defaults = $defaults;
	}

	public function getDefaults() {
		return $this->defaults;
	}

	public function __toString() {
		$out = [];
		foreach ($this as $arg) {
			if (array_key_exists($arg, $this->defaults)) {
				$out[] = $arg . "=" . $this->defaults[$arg];
			} else {
				$out[] = $arg;
			}
		}
		return implode(', ', $out);
	}
}
