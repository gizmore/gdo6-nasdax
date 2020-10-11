<?php
namespace GDO\Nasdax;

use GDO\Core\GDO_Module;
use GDO\Date\GDT_DateTime;
use GDO\Payment\GDT_Money;
use GDO\UI\GDT_Bar;
use GDO\Core\GDT_Success;
use GDO\User\GDO_User;
use GDO\User\GDO_UserSetting;

final class Module_Nasdax extends GDO_Module
{
	public $module_priority = 99;
	public function isSiteModule() { return true; }
    public function getClasses() { return ['GDO\Nasdax\NDX_Company', 'GDO\Nasdax\NDX_History', 'GDO\Nasdax\NDX_Stock']; }
    ############
    ### Init ###
    ############
    public function onIncludeScripts()
    {
        $this->addCSS('css/nasdax.css');
    }
    
    ##############
    ### Config ###
    ##############
    public function getUserSettings()
    {
        return array();
    }
    public function getUserConfig()
    {
        return array(
            GDT_Money::make('nasdax_money')->initial('0.00'),
        );
    }
    public function getConfig()
    {
        return array(
            GDT_DateTime::make('nasdax_last_sync'),
            GDT_Money::make('nasdax_start_money')->initial('10000.00'),
        );
    }
    public function cfgLastSync() { return $this->getConfigValue('nasdax_last_sync'); }
    public function cfgStartMoney() { return $this->getConfigVar('nasdax_start_money'); }
    
    #############
    ### Money ###
    #############
    public function getMoney(GDO_User $user, $money) { GDO_UserSetting::userGet($user, 'nasdax_money'); }
    public function giveMoney(GDO_User $user, $money) { GDO_UserSetting::userInc($user, 'nasdax_money', $money); }
    public function hookUserActivated(GDO_User $user)
    {
        $money = $this->cfgStartMoney();
        $this->giveMoney($user, $money);
        echo GDT_Success::with('msg_nasdax_start', [$money])->renderCell();
    }
    ##############
    ### Render ###
    ##############
    public function renderTabs() { return $this->responsePHP('tabs.php'); }
    public function onRenderFor(GDT_Bar $navbar) { $this->templatePHP('sidebars.php', ['navbar'=>$navbar]); }
}
