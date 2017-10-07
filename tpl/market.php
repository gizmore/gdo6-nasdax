<?php
use GDO\Nasdax\Module_Nasdax;
use GDO\Nasdax\NDX_Company;
use GDO\Table\GDT_Table;
use GDO\Core\GDT_Template;

$module = Module_Nasdax::instance();
$table = NDX_Company::table();
$query = $table->select();

$list = GDT_Table::make();
$list->addFields(array(
    $table->gdoColumn('company_symbol'),
    $table->gdoColumn('company_change_price'),
    $table->gdoColumn('company_close_price'),
    $table->gdoColumn('company_net_worth'),
    GDT_Template::make()->template('Nasdax', 'cell/market_buttons.php'),
));
$list->ordered(true, 'company_net_worth', false);
$list->paginate();
$list->filtered();
$list->query($query);
echo $list->render();
