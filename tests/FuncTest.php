<?php

use PHPAST\Func;
use PHPAST\ArgList;

class FuncTest extends ProgTest {

	public function createNode($label = NULL) {
		return new Func($this->createMock(ArgList::class), [], $label);
	}

	public function testGetArgList() {
		$al = $this->createMock(ArgList::class);
		$f = new Func($al);
		$this->assertSame($al, $f->getArgList());
	}
}
