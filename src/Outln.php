<?php

namespace PHPAST;

class Outln extends Out {
	public function evaluate(SymbolTable $st) {
		$res = parent::evaluate($st);
		print PHP_EOL;
		return $res;
	}
}
