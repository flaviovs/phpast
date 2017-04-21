<?php

namespace PHPAST;

class Func extends Prog {
	protected $args;

	public function __construct(ArgList $args, $label = NULL) {
		parent::__construct($label);
		$this->args = $args;
	}

	public function getArgList() {
		return $this->args;
	}

	public function __toString() {
		return "(" . $this->args . ")\n"
			. (empty($this->nodes) ? "Nop" : parent::__toString());
	}
}
