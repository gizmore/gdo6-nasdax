<?php
use GDO\Nasdax\NDX_Company;
use GDO\Template\GDO_Template;
use GDO\UI\GDO_IconButton;

$field instanceof GDO_Template;
$gdo = $field->gdo; $gdo instanceof NDX_Company;
$sym = $gdo->getSymbol();
echo GDO_IconButton::make()->href(href('Nasdax', 'Buy', "&ndx=$sym"))->icon('attach_money');
echo GDO_IconButton::make()->href(href('Nasdax', 'Sell', "&ndx=$sym"))->icon('money_off');
