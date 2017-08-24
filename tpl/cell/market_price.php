<?php
use GDO\Nasdax\NDX_Company;
use GDO\Payment\GDO_Money;
use GDO\Template\GDO_Template;

$field instanceof GDO_Template;
$gdo = $field->gdo; $gdo instanceof NDX_Company;
$money = GDO_Money::make('company_stock_price')->gdo($gdo)->renderCell();
$class = $gdo->wentDown() ? 'ndx-rate-down' : 'ndx-rate-up';
printf('<span class="%s">%s</span>', $class, $money);
