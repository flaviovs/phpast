<?php

namespace PHPAST;

class PHPLiteralFactory implements LiteralFactory {
	public function create($mixed, $label = NULL) {
		$type = gettype($mixed);

		switch ($type) {
		case 'boolean':
			return new Boolean($mixed, $label);

		case 'integer':
			return new Integer($mixed, $label);

		case 'double':
			return new Float($mixed, $label);

		case 'string':
			return new String($mixed, $label);

		case 'NULL':
			return Null_::get();
		}

		throw new TypeException("Cannot convert type: $type");
	}
}
