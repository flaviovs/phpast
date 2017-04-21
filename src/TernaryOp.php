<?php

namespace PHPAST;

abstract class TernaryOp extends Node {
	protected $node1;
	protected $node2;
	protected $node3;

	public function __construct(Node $node1, Node $node2, Node $node3,
	                            $label = NULL) {
		parent::__construct($label);
		$this->node1 = $node1;
		$this->node2 = $node2;
		$this->node3 = $node3;
	}
}
