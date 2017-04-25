<?php

use PHPAST\PHPLiteralFactory;
use PHPAST\Boolean;
use PHPAST\Integer;
use PHPAST\Float;
use PHPAST\String;
use PHPAST\Null_;
use PHPAST\TypeException;

class PHPLiteralFactoryTest extends PHPUnit\Framework\TestCase {

	public function testBoolean() {
		$fac = new PHPLiteralFactory();
		$this->assertInstanceOf(Boolean::class, $fac->create(TRUE));
		$this->assertInstanceOf(Boolean::class, $fac->create(FALSE));
	}

	public function testInteger() {
		$fac = new PHPLiteralFactory();
		$this->assertInstanceOf(Integer::class, $fac->create(-1));
		$this->assertInstanceOf(Integer::class, $fac->create(0));
	}

	public function testFloat() {
		$fac = new PHPLiteralFactory();
		$this->assertInstanceOf(Float::class, $fac->create(1.0));
		$this->assertInstanceOf(Float::class, $fac->create(1.1));
	}

	public function testString() {
		$fac = new PHPLiteralFactory();
		$this->assertInstanceOf(String::class, $fac->create("foo"));
		$this->assertInstanceOf(String::class, $fac->create(""));
	}

	public function testNull() {
		$fac = new PHPLiteralFactory();
		$this->assertSame(Null_::get(), $fac->create(NULL));
	}

	public function testException() {
		$fac = new PHPLiteralFactory();
		$this->expectException(TypeException::class);
		$fac->create(new StdClass());
	}
}
