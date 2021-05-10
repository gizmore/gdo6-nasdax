<?php
namespace GDO\Nasdax\Method;

use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\MethodForm;
use GDO\Nasdax\Module_Nasdax;
use GDO\Nasdax\NDX_Company;
use GDO\DB\GDT_Int;
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
            $tabs->addField($this->company->responseCard());
            $response = parent::execute();
        }
        
        return $tabs->addField($response);
    }
    
    public function createForm(GDT_Form $form)
    {
        $form->addFields(array(
            GDT_Int::make('stock_amt')->min(1)->max($this->company->getStock()),
            GDT_AntiCSRF::make(),
        ));
        $form->actions()->addField(GDT_Submit::make());
    }
}
