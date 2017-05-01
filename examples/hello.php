<?php

require __DIR__ . '/../vendor/autoload.php';

$node = new PHPAST\Outln(['Hello world!']);
$node->evaluate(new PHPAST\FlatSymbolTable([]));
