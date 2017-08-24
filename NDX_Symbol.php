<?php
namespace GDO\Nasdax;

use GDO\Template\GDO_Template;
use GDO\Type\GDO_String;

class NDX_Symbol extends GDO_String
{
    public function defaultLabel() { return $this->label('symbol'); }
    
    public function __construct()
    {
        $this->min = 1;
        $this->max = 8;
        $this->ascii();
        $this->caseS();
        $this->unique();
        $this->notNull();
    }
    
    /**
     * @return NDX_Company
     */
    public function getCompany()
    {
        return $this->gdo;
    }
    
    public function renderCell()
    {
        return GDO_Template::php('Nasdax', 'cell/symbol.php', ['field' => $this]);
    }
}
