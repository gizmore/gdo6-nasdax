<?php
namespace GDO\Nasdax;

use GDO\DB\Cache;
use GDO\Core\GDO;
use GDO\DB\GDT_AutoInc;
use GDO\Date\GDT_DateTime;
use GDO\Payment\GDT_Money;
use GDO\Core\GDT_Template;
use GDO\DB\GDT_Int;
use GDO\DB\GDT_String;
use GDO\User\GDO_User;

final class NDX_Company extends GDO
{
    public function gdoCached() { return false; }
    
    public function gdoColumns()
    {
        return array(
            GDT_AutoInc::make('company_id'),
            NDX_Symbol::make('company_symbol')->unique(),
            GDT_String::make('company_name')->label('name')->max(256)->notNull(),
            # Current Rate data
            GDT_Int::make('company_stock')->notNull(),
            GDT_Money::make('company_close_price')->notNull()->label('net_price'),
            GDT_Money::make('company_change_price')->notNull()->label('net_change'),
            GDT_Money::make('company_net_worth')->notNull()->label('net_worth'),
            GDT_DateTime::make('company_data_time'),
        );
    }
    
    public function getName() { return $this->getVar('company_name'); }
    public function getSymbol() { return $this->getVar('company_symbol'); }
    public function getStock() { return $this->getVar('company_stock'); }
    public function getPrice() { return $this->getVar('company_close_price'); }
    public function getChange() { return $this->getVar('company_change_price'); }
    public function wentDown() { return $this->getChange() < 0; }
    public function getUpdateDate() { return $this->getVar('company_data_time'); }
    public function getUpdateTime() { return $this->getValue('company_data_time'); }
    
    public function getUserStock(GDO_User $user) { return NDX_Stock::getStock($this, $user); }

    ###############
    ### Factory ###
    ###############
    /**
     * @param string $symbol
     * @return self
     */
    public static function getBySymbol($symbol=null)
    {
        if ($symbol)
        {
            $companies = self::table()->all();
            return isset($companies[$symbol]) ? $companies[$symbol] : null;
        }
    }
    /**
     * @return self[]
     */
    public function all()
    {
        static $cache;
        if (!isset($cache))
        {
            if (false === ($cache = Cache::get('ndx_companies')))
            {
                $cache = $this->queryAll();
                Cache::set('ndx_companies', $cache);
            }
            else
            {
                Cache::heat('ndx_companies', $cache);
            }
        }
        return $cache;
    }
    private function queryAll()
    {
        return self::table()->select('company_symbol, ndx_company.*')->exec()->fetchAllArrayAssoc2dObject();
    }
    public function gdoAfterCreate()
    {
    }
    ##############
    ### Render ###
    ##############
    public function renderCard() { return GDT_Template::php('Nasdax', 'card/company.php', ['company'=>$this]); }
}
