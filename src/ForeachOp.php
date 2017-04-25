<?php

namespace PHPAST;

class ForeachOp extends Node {
	protected $lref;
	protected $offset;
	protected $value;
	protected $node;

	public function __construct(Ref $lref, Ref $offset, Ref $value,
	                            Node $node, $label = NULL) {

		parent::__construct($label);
		$this->lref = $lref;
		$this->offset = $offset;
		$this->value = $value;
		$this->node = $node;
	}

	public function evaluate(SymbolTable $st) {
		$res = Null_::get();
		$vlist = $this->lref->evaluate($st);
		if (!($vlist instanceof VList)) {
			throw new TypeError($this->label, get_class($vlist));
		}
		foreach ($vlist as $k => $v) {
			$this->offset->assign($st, new Identifier($k));
			$this->value->assign($st, $v);
			$res = $this->node->evaluate($st);
		}
		return $res;
	}

	public function __toString() {
		return 'Foreach (' . $this->lref
			. '; ' . $this->offset
			. ' => ' . $this->value . ")\n\t"
			. str_replace("\n", "\n\t", $this->node);
	}

}
