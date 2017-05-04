<?php

namespace PHPAST;

class XorOp extends BinaryOp {

	public function evaluate(SymbolTable $st) {
		$r1 = $this->node1->evaluate($st)->getValue();
		$r2 = $this->node2->evaluate($st)->getValue();
		return (($r1 xor $r2)
		        ? ($r1
		           ? $this->node1
		           : $this->node2)
		        : Boolean::getFalse());
	}

	public function __toString() {
		return '(' . $this->node1 . ' >< ' . $this->node2 . ')';
	}
}
