<?php

namespace PHPAST;

class Outln extends Out {
	public function evaluate(SymbolTable $st) {
		parent::evaluate($st);
		print PHP_EOL;
	}
}
