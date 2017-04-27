<?php

namespace PHPAST;

class Nop extends Node {
	static protected $instance;

	public function evaluate(SymbolTable $st) {
		return Null_::get();
	}

	public function __toString() {
		return 'Nop';
	}

	static public function get() {
		if (static::$instance === NULL) {
			static::$instance = new static(NULL);
		}
		return static::$instance;
	}
}
