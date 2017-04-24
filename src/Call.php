<?php

namespace PHPAST;

class Call extends Node {
	protected $id;
	protected $args;

	public function __construct(Identifier $id,
								FlatSymbolTable $args,
								$label = NULL) {
		parent::__construct($label);
		$this->id = $id;
		$this->args = $args;
	}

	public function evaluate(SymbolTable $st) {
		$fnode = $st[(string)$this->id->evaluate($st)];
		if (!($fnode instanceof Func)) {
			throw new TypeException($this->label,
			                        "$this->id is not a function");
		}

		$local_st = new ChainedScopeSymbolTable([], $st, $this->label);

		$arglist = $fnode->getArgList();
		$defaults = $arglist->getDefaults();

		foreach ($arglist as $arg) {
			if (isset($this->args[$arg])) {
				$local_st[$arg] = $this->args[$arg]->evaluate($st);
			} else if (isset($this->defaults[$arg])) {
				$local_st[$arg] = $this->defaults[$arg]->evaluate($st);
			} else {
				throw new NameException($this->label,
				                        "Missing function argument: $arg");
			}
		}

		try {
			return $fnode->evaluate($local_st);
		} catch (ReturnException $ex) {
			return $ex->getLiteral();
		}
	}

	public function __toString() {
		$args = $this->args->getArrayCopy();
		return $this->id . "(" . implode(", ",
										 array_map(function($k) use ($args) {
												 return "$k=$args[$k]";
											 }, array_keys($args))) . ")";
	}
}
