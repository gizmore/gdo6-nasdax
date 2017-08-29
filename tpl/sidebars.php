<?php
use GDO\Template\GDT_Bar;
use GDO\UI\GDT_Link;

$navbar instanceof GDT_Bar;
if ($navbar->isTop())
{
    $navbar->addField(GDT_Link::make('link_nasdax')->href(href('Nasdax', 'Home')));
}

