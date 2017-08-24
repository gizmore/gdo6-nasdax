<?php
use GDO\Template\GDO_Bar;
use GDO\UI\GDO_Link;

$bar = GDO_Bar::make();
$bar->addFields(array(
    GDO_Link::make('link_market')->href(href('Nasdax', 'Market')),
    GDO_Link::make('link_stock')->href(href('Nasdax', 'Stock')),
    GDO_Link::make('link_traders')->href(href('Nasdax', 'Traders')),
));
echo $bar->render();
