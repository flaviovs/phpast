<?php

namespace PHPAST;

class DecOp extends IncOp {
	public function __construct(Ref $ref, $val = 1, $label = NULL) {
		parent::__construct($ref, -$val, $label);
	}

	public function __toString() {
		return $this->node . ' -= ' . -$this->val;
	}
}
