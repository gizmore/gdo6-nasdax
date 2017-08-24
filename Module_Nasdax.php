<?php
namespace GDO\Nasdax;

use GDO\Core\Module;
use GDO\Date\GDO_DateTime;
use GDO\Payment\GDO_Money;
use GDO\Template\GDO_Bar;
use GDO\Template\Message;
use GDO\User\User;
use GDO\User\UserSetting;

final class Module_Nasdax extends Module
{
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
            GDO_Money::make('nasdax_money')->initial('0.00'),
        );
    }
    public function getConfig()
    {
        return array(
            GDO_DateTime::make('nasdax_last_sync'),
            GDO_Money::make('nasdax_start_money')->initial('10000.00'),
        );
    }
    public function cfgLastSync() { return $this->getConfigValue('nasdax_last_sync'); }
    public function cfgStartMoney() { return $this->getConfigVar('nasdax_start_money'); }
    
    #############
    ### Money ###
    #############
    public function getMoney(User $user, $money) { UserSetting::userGet($user, 'nasdax_money'); }
    public function giveMoney(User $user, $money) { UserSetting::userInc($user, 'nasdax_money', $money); }
    public function hookUserActivated(User $user)
    {
        $money = $this->cfgStartMoney();
        $this->giveMoney($user, $money);
        echo Message::message('msg_nasdax_start', [$money]);
    }
    ##############
    ### Render ###
    ##############
    public function renderTabs() { return $this->templatePHP('tabs.php'); }
    public function onRenderFor(GDO_Bar $navbar) { $this->templatePHP('sidebars.php', ['navbar'=>$navbar]); }
}
