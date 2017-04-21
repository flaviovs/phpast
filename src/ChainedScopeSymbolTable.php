<?php

namespace PHPAST;

class ChainedScopeSymbolTable extends CompositeSymbolTable {
	public function offsetGet($offset) {
		try {
			return parent::offsetGet($offset);
		} catch (NameException $ex) {
			return $this->parent[$offset];
		}
	}
}
