<?php

namespace PHPAST;

class CompositeSymbolTable extends FlatSymbolTable {
	protected $parent;

	public function __construct($symbols, SymbolTable $parent) {
		parent::__construct($symbols);
		$this->parent = $parent;
	}
}
