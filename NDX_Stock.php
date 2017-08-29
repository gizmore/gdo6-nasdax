<?php
namespace GDO\Nasdax;

use GDO\DB\GDO;
use GDO\DB\GDT_AutoInc;
use GDO\DB\GDT_CreatedAt;
use GDO\DB\GDT_CreatedBy;
use GDO\DB\GDT_Object;
use GDO\Payment\GDT_Money;
use GDO\Type\GDT_Int;
use GDO\User\GDT_User;
use GDO\User\GDO_User;

final class NDX_Stock extends GDO
{
    public function gdoColumns()
    {
        return array(
            GDT_AutoInc::make('stock_id'),
            GDT_User::make('stock_user')->index()->notNull(),
            GDT_Object::make('stock_company')->table(NDX_Company::table())->notNull(),
            GDT_Int::make('stock_amt')->unsigned()->notNull(),
            GDT_Money::make('stock_bought')->notNull(),
            GDT_CreatedAt::make('stock_created'),
            GDT_CreatedBy::make('stock_creator'),
        );
    }

    public function getUserStock(NDX_Company $company, GDO_User $user)
    {
        $query = self::table()->select('SUM(stock_amt)');
        $query->where("stock_user={$user->getID()} AND stock_company={$company->getID()}");
        return $query->exec()->fetchValue();
    }
    
    
}
