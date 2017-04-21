<?php

namespace PHPAST;

abstract class BinaryOp extends Node {
	protected $node1;
	protected $node2;

	public function __construct(Node $node1, Node $node2, $label = NULL) {
		parent::__construct($label);
		$this->node1 = $node1;
		$this->node2 = $node2;
	}
}
