<?php
namespace GDO\Nasdax;

use GDO\Core\GDO;
use GDO\DB\GDT_AutoInc;
use GDO\DB\GDT_CreatedAt;
use GDO\DB\GDT_CreatedBy;
use GDO\DB\GDT_Object;
use GDO\Payment\GDT_Money;
use GDO\DB\GDT_Int;
use GDO\User\GDT_User;
use GDO\User\GDO_User;
use GDO\DB\GDT_Index;

final class NDX_Stock extends GDO
{
    public function gdoColumns()
    {
        return array(
            GDT_AutoInc::make('stock_id'),
            GDT_User::make('stock_user')->notNull(),
            GDT_Object::make('stock_company')->table(NDX_Company::table())->notNull(),
            GDT_Int::make('stock_amt')->unsigned()->notNull(),
            GDT_Money::make('stock_bought')->notNull(),
            GDT_CreatedAt::make('stock_created'),
            GDT_CreatedBy::make('stock_creator'),
            GDT_Index::make('stock_user_index')->indexColumns('stock_user')->hash(),
        );
    }

    public function getUserStock(NDX_Company $company, GDO_User $user)
    {
        $query = self::table()->select('SUM(stock_amt)');
        $query->where("stock_user={$user->getID()} AND stock_company={$company->getID()}");
        return $query->exec()->fetchValue();
    }
    
    
}
