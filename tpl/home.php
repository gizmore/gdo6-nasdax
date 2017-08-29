<?php
use GDO\Nasdax\Module_Nasdax;
use GDO\Template\GDT_Box;

echo Module_Nasdax::instance()->renderTabs();

$box = GDT_Box::make();
$box->title(t('nasdax_home_title'));
$box->html(t('nasdax_home_content'));
echo $box;

