<?php
namespace GDO\Nasdax;

use GDO\DB\GDO;
use GDO\DB\GDO_AutoInc;
use GDO\DB\GDO_Object;
use GDO\Date\GDO_DateTime;
use GDO\Payment\GDO_Money;

final class NDX_History extends GDO
{
    public function gdoEngine() { return self::MYISAM; }
    public function gdoColumns()
    {
        return array(
            GDO_AutoInc::make('ndx_id'),
            GDO_Object::make('ndx_company')->table(NDX_Company::table()),
            # Rate data
            GDO_Money::make('ndx_close_price')->notNull()->label('net_price'),
            GDO_DateTime::make('ndx_time'),
        );
    }
}
