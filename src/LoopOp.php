<?php

namespace PHPAST;

class LoopOp extends Node {
	protected $node;

	public function __construct(Node $node, $label = NULL) {
		parent::__construct($label);
		$this->node = $node;
	}

	protected function loop(SymbolTable $st, &$res) {
		try {
			$res = $this->node->evaluate($st);
		} catch (ContinueException $ex) {
			if ($ex->current()) {
				return TRUE;
			}
			$ex->advance();
			throw $ex;
		} catch (BreakException $ex) {
			if ($ex->current()) {
				return FALSE;
			}
			$ex->advance();
			throw $ex;
		}
		return TRUE;
	}

	public function evaluate(SymbolTable $st) {
		$res = Null_::get();
		while ($this->loop($st, $res)) {
			// NOTHING
		}
		return $res;
	}

	public function __toString() {
		return "Loop\n\t" . str_replace("\n", "\n\t", $this->node->repr());
	}
}
