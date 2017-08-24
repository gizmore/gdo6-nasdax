<?php
namespace GDO\Nasdax;

use GDO\DB\Cache;
use GDO\DB\GDO;
use GDO\DB\GDO_AutoInc;
use GDO\Date\GDO_DateTime;
use GDO\Payment\GDO_Money;
use GDO\Template\GDO_Template;
use GDO\Type\GDO_Int;
use GDO\Type\GDO_String;
use GDO\User\User;

final class NDX_Company extends GDO
{
    public function gdoCached() { return false; }
    
    public function gdoColumns()
    {
        return array(
            GDO_AutoInc::make('company_id'),
            NDX_Symbol::make('company_symbol')->unique(),
            GDO_String::make('company_name')->label('name')->max(256)->notNull(),
            # Current Rate data
            GDO_Int::make('company_stock')->notNull(),
            GDO_Money::make('company_close_price')->notNull()->label('net_price'),
            GDO_Money::make('company_change_price')->notNull()->label('net_change'),
            GDO_Money::make('company_net_worth')->notNull()->label('net_worth'),
            GDO_DateTime::make('company_data_time'),
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
    
    public function getUserStock(User $user) { return NDX_Stock::getStock($this, $user); }

    ###############
    ### Factory ###
    ###############
    /**
     * @param string $symbol
     * @return self
     */
    public static function getBySymbol(string $symbol=null)
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
            if (!($cache = Cache::get('ndx_companies')))
            {
                $cache = $this->queryAll();
                Cache::set('ndx_companies', $cache);
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
    public function renderCard() { return GDO_Template::php('Nasdax', 'card/company.php', ['company'=>$this]); }
}
