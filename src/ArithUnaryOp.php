<?php

namespace PHPAST;

abstract class ArithUnaryOp extends UnaryOp {
	public function arithPromote($value, Literal $lit) {
		if ($lit instanceof Float) {
			new Float($value, $this->label);
		}
		return new Integer($value, $this->label);
	}
}
