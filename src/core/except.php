<?php

namespace PHPAST;

class Exception extends \Exception {}

class FlowException extends Exception {}

class ReturnException extends FlowException {
	protected $literal;

	public function __construct(Literal $literal) {
		parent::__construct();
		$this->literal = $literal;
	}

	public function getLiteral() {
		return $this->literal;
	}
}

class LoopException extends FlowException {
	protected $blocks;

	public function __construct(Integer $blocks = NULL) {
		parent::__construct();
		$this->blocks = $blocks;
	}

	public function getBlocks() {
		return $this->blocks;
	}
}

class ContinueException extends LoopException {}
class BreakException extends LoopException {}

class EvalException extends Exception {
	protected $label;

	public function __construct($label, $message = "", $code = 0,
	                            \Throwable $previous = NULL) {
		parent::__construct($message, $code, $previous);
		$this->label = $label;
	}

	public function __toString() {
		return "$this->label: " . parent::__toString();
	}

	public function getLabel() {
		return $this->label;
	}
}

class DivisionByZeroException extends EvalException {}
class TypeException extends EvalException {}
class NameException extends EvalException {}
