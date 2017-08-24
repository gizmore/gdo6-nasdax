<?php
use GDO\Template\GDO_Bar;
use GDO\UI\GDO_Link;

$navbar instanceof GDO_Bar;
if ($navbar->isTop())
{
    $navbar->addField(GDO_Link::make('link_nasdax')->href(href('Nasdax', 'Home')));
}

