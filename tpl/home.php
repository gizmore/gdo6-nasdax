<?php
use GDO\Nasdax\Module_Nasdax;
use GDO\UI\GDT_Panel;

echo Module_Nasdax::instance()->renderTabs();

$box = GDT_Panel::make();
$box->title(t('nasdax_home_title'));
$box->html(t('nasdax_home_content'));
echo $box;

