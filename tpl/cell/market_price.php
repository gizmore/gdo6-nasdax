<?php
use GDO\Nasdax\NDX_Company;
use GDO\Payment\GDT_Money;
use GDO\Core\GDT_Template;

$field instanceof GDT_Template;
$gdo = $field->gdo; $gdo instanceof NDX_Company;
$money = GDT_Money::make('company_stock_price')->gdo($gdo)->renderCell();
$class = $gdo->wentDown() ? 'ndx-rate-down' : 'ndx-rate-up';
printf('<span class="%s">%s</span>', $class, $money);
