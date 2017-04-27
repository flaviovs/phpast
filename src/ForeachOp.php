<?php

namespace PHPAST;

class ForeachOp extends LoopOp {
	protected $vlist;
	protected $offset;
	protected $value;

	public function __construct(VList $vlist, Ref $offset, Ref $value,
	                            Node $node, $label = NULL) {
		parent::__construct($node, $label);
		$this->vlist = $vlist;
		$this->offset = $offset;
		$this->value = $value;
	}

	public function evaluate(SymbolTable $st) {
		$res = Null_::get();
		foreach ($this->vlist as $k => $v) {
			$this->offset->assign($st, new Identifier($k));
			$this->value->assign($st, $v);
			if (!$this->loop($st, $res)) {
				break;
			}
		}
		return $res;
	}

	public function __toString() {
		return 'Foreach (' . $this->vlist
			. '; ' . $this->offset
			. ' => ' . $this->value . ")\n\t"
			. str_replace("\n", "\n\t", $this->node);
	}

}
