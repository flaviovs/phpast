<?php

namespace PHPAST;

class OffsetRef extends Ref {
	protected $vlist;

	public function __construct(VList $list, Identifier $offset,
	                            $label = NULL) {
		parent::__construct($offset, $label);
		$this->vlist = $list;
	}

	public function evaluate(SymbolTable $st) {
		return $this->vlist[(string)$this->name->evaluate($st)];
	}

	public function assign(SymbolTable $st, Node $value) {
		return ($this->vlist[(string)$this->name->evaluate($st)] = $value);
	}

	public function __toString() {
		return '[' . $this->name . ']';
	}
}
