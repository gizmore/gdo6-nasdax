<?php
namespace GDO\Nasdax\Method;

use GDO\Core\Method;

final class Market extends Method
{
    public function execute()
    {
        return $this->templatePHP('market.php');
    }
}
