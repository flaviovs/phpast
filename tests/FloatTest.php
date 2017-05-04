<?php

use PHPAST\Float;

class FloatTest extends NumberTest {

	public function createNode($label = NULL) {
		return new Float(3.14, $label);
	}

	public function testNanConstant() {
		$nan = Float::getNan();
		$this->assertSame($nan, Float::getNan());
	}

	public function testNanToString() {
		$this->assertEquals('NaN', (string)Float::getNan());
	}

	public function testInfToString() {
		$this->assertEquals('Inf', (string)Float::getInf());
	}
}
