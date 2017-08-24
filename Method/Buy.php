<?php
namespace GDO\Nasdax\Method;

use GDO\Form\GDO_AntiCSRF;
use GDO\Form\GDO_Form;
use GDO\Form\GDO_Submit;
use GDO\Form\MethodForm;
use GDO\Nasdax\Module_Nasdax;
use GDO\Nasdax\NDX_Company;
use GDO\Type\GDO_Int;
use GDO\Util\Common;

final class Buy extends MethodForm
{
    private $company;

    public function execute()
    {
        $tabs = Module_Nasdax::instance()->renderTabs();
        
        if (!($this->company = NDX_Company::getBySymbol(Common::getGetString('ndx'))))
        {
            $response = $this->error('err_ndx_company');
        }
        else
        {
            $tabs->add($this->company->renderCard());
            $response = parent::execute();
        }
        
        return $tabs->add($response);
    }
    
    public function createForm(GDO_Form $form)
    {
        $form->addFields(array(
            GDO_Int::make('stock_amt')->min(1)->max($this->company->getStock()),
            GDO_Submit::make(),
            GDO_AntiCSRF::make(),
        ));
        return $this->templatePHP('home.php');
    }
}
