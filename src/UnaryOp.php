<?php

namespace PHPAST;

abstract class UnaryOp extends Node {
	protected $node;

	public function __construct(Node $node, $label = NULL) {
		parent::__construct($label);
		$this->node = $node;
	}
};
