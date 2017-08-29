<?php
namespace GDO\Nasdax\Method;

use GDO\Nasdax\NDX_Stock;
use GDO\Table\MethodQueryList;
use GDO\User\GDO_User;

final class Stock extends MethodQueryList
{
    public function gdoTable()
    {
        return NDX_Stock::table();
    }
    
    public function gdoQuery()
    {
        return parent::gdoQuery()->where('stock_user='.GDO_User::current()->getID());
    }

}
