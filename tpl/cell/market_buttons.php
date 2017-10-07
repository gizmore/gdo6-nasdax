<?php
use GDO\Nasdax\NDX_Company;
use GDO\Core\GDT_Template;
use GDO\UI\GDT_IconButton;

$field instanceof GDT_Template;
$gdo = $field->gdo; $gdo instanceof NDX_Company;
$sym = $gdo->getSymbol();
echo GDT_IconButton::make()->href(href('Nasdax', 'Buy', "&ndx=$sym"))->icon('attach_money');
echo GDT_IconButton::make()->href(href('Nasdax', 'Sell', "&ndx=$sym"))->icon('money_off');
