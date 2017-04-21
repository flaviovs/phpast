<?php

namespace PHPAST;

class Exception extends \Exception {}

class ReturnException extends Exception {
	protected $literal;

	public function __construct(Literal $literal) {
		parent::__construct();
		$this->literal = $literal;
	}

	public function getLiteral() {
		return $this->literal;
	}
}

class EvalException extends Exception {
}

class DivisionByZeroException extends EvalException {}
class TypeException extends EvalException {}
class NameException extends EvalException {}
