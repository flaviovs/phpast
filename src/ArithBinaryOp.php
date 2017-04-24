<?php

namespace PHPAST;

abstract class ArithBinaryOp extends BinaryOp {
	public function arithPromote($value, Literal $lit1, Literal $lit2) {
		if ($lit1 instanceof Float || $lit2 instanceof Float) {
			return new Float($value, $this->label);
		}
		return new Integer($value, $this->label);
	}
}
