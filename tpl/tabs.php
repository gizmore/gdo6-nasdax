<?php
use GDO\Template\GDT_Bar;
use GDO\UI\GDT_Link;

$bar = GDT_Bar::make();
$bar->addFields(array(
    GDT_Link::make('link_market')->href(href('Nasdax', 'Market')),
    GDT_Link::make('link_stock')->href(href('Nasdax', 'Stock')),
    GDT_Link::make('link_traders')->href(href('Nasdax', 'Traders')),
));
echo $bar->render();
