<?php

use PHPAST\Boolean;

class BooleanTest extends NumberTest {

	public function createNode($label = NULL) {
		return new Boolean(TRUE, $label);
	}

	public function testToString() {
		$node = new Boolean(TRUE);
		$this->assertEquals('TRUE', (string)$node);
		$node = new Boolean(FALSE);
		$this->assertEquals('FALSE', (string)$node);
	}

	public function testTrueConstant() {
		$node = Boolean::getTrue();
		$this->assertInstanceOf(Boolean::class, $node);
		$this->assertTrue($node->getValue());
		$this->assertSame($node, Boolean::getTrue());
	}

	public function testFalseConstant() {
		$node = Boolean::getFalse();
		$this->assertInstanceOf(Boolean::class, $node);
		$this->assertFalse($node->getValue());
		$this->assertSame($node, Boolean::getFalse());
	}
}
