<?php
namespace GDO\Nasdax\Method;

use GDO\Nasdax\NDX_Stock;
use GDO\Table\MethodQueryList;
use GDO\User\User;

final class Stock extends MethodQueryList
{
    public function gdoTable()
    {
        return NDX_Stock::table();
    }
    
    public function gdoQuery()
    {
        return parent::gdoQuery()->where('stock_user='.User::current()->getID());
    }

}
