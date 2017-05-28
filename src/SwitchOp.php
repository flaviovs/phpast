<?php

namespace PHPAST;

class SwitchOp extends Node {
	protected $cond;
	protected $values;
	protected $nodes;

	public function __construct(Node $cond,
	                            array $values, array $nodes,
	                            $label = NULL) {

		if (count($values) != count($nodes)) {
			throw new UnderflowException(
				$label,
				"Value count does not match node count"
			);
		}

		parent::__construct($label);

		$this->cond = $cond;
		$this->values = $values;
		$this->nodes = $nodes;
	}

	public function evaluate(SymbolTable $st) {
		$cond = $this->cond->evaluate($st);
		$this->checkType($cond, Literal::class);

		$nr = count($this->values);
		for ($i = 0; $i < $nr; $i++) {
			$val = $this->values[$i];
			$this->checkType($val, Literal::class);
			if ($val->equalsTo($cond)) {
				return $this->nodes[$i]->evaluate($st);
			}
		}
		return Null_::get();
	}
}
