<?php

namespace PHPAST;

abstract class ArithBinaryOp extends BinaryOp {
	public function arithPromote($value, Literal $lit1, Literal $lit2) {
		if ($lit2 instanceof Float || $lit2 instanceof Float) {
			new Float($value, $this->label);
		}
		return new Integer($value, $this->label);
	}
}
