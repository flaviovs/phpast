<?php

use PHPAST\Value;

class ValueTest extends NodeTest {

	public function createNode($label = NULL) {
		return new Value('test node', $label);
	}

	public function testEvaluate() {
		$node = $this->createNode();
		$this->assertSame($node,
		                  $node->evaluate($this->getMockSymbolTable()));
	}

	public function testToString() {
		$node = new Value('foo');
		$this->assertEquals('foo', (string)$node);
	}

	public function equalDataProvider() {
		return [
			['a', 'a'],
			[NULL, NULL],
			[123, 123],
		];
	}

	/**
	 * @dataProvider equalDataProvider
	 */
	public function testEqualsTo($v1, $v2) {
		$val1 = new Value($v1);
		$val2 = new Value($v2);

		$this->assertTrue($val1->equalsTo($val2));
		$this->assertTrue($val2->equalsTo($val1));
	}

	public function notEqualDataProvider() {
		return [
			['a', 'abc'],
			[NULL, 1],
			[1, '1'],
			[0, '0abc'],
		];
	}

	/**
	 * @dataProvider notEqualDataProvider
	 */
	public function testNotEqualsTo($v1, $v2) {
		$val1 = new Value($v1);
		$val2 = new Value($v2);

		$this->assertFalse($val1->equalsTo($val2));
		$this->assertFalse($val2->equalsTo($val1));
	}
}
