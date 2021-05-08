<?php
namespace GDO\Nasdax\Method;

use GDO\Core\Application;
use GDO\Cronjob\MethodCronjob;
use GDO\DB\Cache;
use GDO\Date\Time;
use GDO\Nasdax\Module_Nasdax;
use GDO\Nasdax\NDX_Company;
use GDO\Net\HTTP;
/**
 * @author gizmore
 *
 */
final class Cronjob extends MethodCronjob
{
    private $urlAmex = 'http://www.wsj.com/public/resources/documents/AMEX.csv';
    private $urlNyse = 'https://www.wsj.com/public/resources/documents/NYSE.csv';
    private $urlEurodax = 'http://www3.wsj.com/public/resources/documents/USETFs.csv';
    private $urlNasdaq = 'http://www.wsj.com/public/resources/documents/Nasdaq.csv';
//     private $urlFinparse = 'http://www.somemorespace.com/finparse/funds.csv';
    
    public function run()
    {
        $module = Module_Nasdax::instance();
        $last = intval($module->cfgLastSync() / 3600);
        $now = intval(Application::$TIME / 3600);
        if ($last !== $now)
        {
            Cache::remove('ndx_companies');
            $this->updateRates();
            Cache::remove('ndx_companies');
            $module->saveConfigVar('nasdax_last_sync', Time::getDate());
        }
    }
    
    private function updateRates()
    {
        $this->updateWSJ($this->urlAmex);
        $this->updateWSJ($this->urlNyse);
        $this->updateWSJ($this->urlEurodax);
        $this->updateWSJ($this->urlNasdaq);
    }
    
    private function updateWSJ($url)
    {
        $this->logNotice("Requesting $url");
        if ($response = HTTP::getFromURL($url))
        {
            $count = 0;
            $time = null;

            foreach (explode("\n", $response) as $row)
            {
                $count++;
                switch ($count)
                {
                    case 1: break;
                    case 2: $time = strtotime(trim($row, '"')); break;
                    case 3: break;
                    case 4: break;
                    default:
                        $row = str_getcsv($row);
                        if (count($row) > 1)
                        {
                            $this->updateRate($row[1], $row[0], $row[8], $row[5], $row[6], $time);
                        }
                        break;
                }
            }
        }
    }
    
    private function updateRate($symbol, $name, $stock, $close, $change, $time)
    {
        $stock = (int) str_replace(',', '', $stock);
        if (!($company = NDX_Company::getBySymbol($symbol)))
        {
            NDX_Company::blank(array(
                'company_symbol' => $symbol,
                'company_name' => $name,
                # stock data
                'company_stock' => $stock,
                'company_close_price' => $close,
                'company_change_price' => $change,
                'company_net_worth' => $stock * $close,
                'company_data_time' => Time::getDate($time),
            ))->insert();
        }
        elseif ($company->getUpdateTime() < $time)
        {
            $company->saveVars(array(
                'company_stock' => $stock,
                'company_close_price' => $close,
                'company_change_price' => $change,
                'company_net_worth' => $stock * $close,
                'company_data_time' => Time::getDate($time),
            ));
        }
        
    }
}
