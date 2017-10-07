<?php
namespace GDO\Nasdax;

use GDO\Core\GDT_Template;
use GDO\DB\GDT_String;

class NDX_Symbol extends GDT_String
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
        return GDT_Template::php('Nasdax', 'cell/symbol.php', ['field' => $this]);
    }
}
