<?php
use GDO\Nasdax\NDX_Symbol;

$field instanceof NDX_Symbol;
$gdo = $field->getCompany();
$name = $gdo->getName();
$symbol = $gdo->getSymbol();
printf('<md-tooltip>%1$s</md-tooltip><a href="javascript:;" title="%1$s">%2$s</a>', $name, $symbol);
