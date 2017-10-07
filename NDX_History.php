<?php
namespace GDO\Nasdax;

use GDO\Core\GDO;
use GDO\DB\GDT_AutoInc;
use GDO\DB\GDT_Object;
use GDO\Date\GDT_DateTime;
use GDO\Payment\GDT_Money;

final class NDX_History extends GDO
{
    public function gdoEngine() { return self::MYISAM; }
    public function gdoColumns()
    {
        return array(
            GDT_AutoInc::make('ndx_id'),
            GDT_Object::make('ndx_company')->table(NDX_Company::table()),
            # Rate data
            GDT_Money::make('ndx_close_price')->notNull()->label('net_price'),
            GDT_DateTime::make('ndx_time'),
        );
    }
}
