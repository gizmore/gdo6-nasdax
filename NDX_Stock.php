<?php
namespace GDO\Nasdax;

use GDO\DB\GDO;
use GDO\DB\GDO_AutoInc;
use GDO\DB\GDO_CreatedAt;
use GDO\DB\GDO_CreatedBy;
use GDO\DB\GDO_Object;
use GDO\Payment\GDO_Money;
use GDO\Type\GDO_Int;
use GDO\User\GDO_User;
use GDO\User\User;

final class NDX_Stock extends GDO
{
    public function gdoColumns()
    {
        return array(
            GDO_AutoInc::make('stock_id'),
            GDO_User::make('stock_user')->index()->notNull(),
            GDO_Object::make('stock_company')->table(NDX_Company::table())->notNull(),
            GDO_Int::make('stock_amt')->unsigned()->notNull(),
            GDO_Money::make('stock_bought')->notNull(),
            GDO_CreatedAt::make('stock_created'),
            GDO_CreatedBy::make('stock_creator'),
        );
    }

    public function getUserStock(NDX_Company $company, User $user)
    {
        $query = self::table()->select('SUM(stock_amt)');
        $query->where("stock_user={$user->getID()} AND stock_company={$company->getID()}");
        return $query->exec()->fetchValue();
    }
    
    
}
