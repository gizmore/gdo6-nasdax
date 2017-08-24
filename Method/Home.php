<?php
namespace GDO\Nasdax\Method;

use GDO\Core\Method;

final class Home extends Method
{
    public function execute()
    {
        return $this->templatePHP('home.php');
    }
}
