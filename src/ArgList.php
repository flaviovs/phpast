<?php

namespace PHPAST;

class ArgList extends \ArrayObject {
	protected $defaults = [];

	public function __construct(array $args) {
		parent::__construct();
		foreach ($args as $name => $value) {
			$this[$name] = $value;
		}
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
