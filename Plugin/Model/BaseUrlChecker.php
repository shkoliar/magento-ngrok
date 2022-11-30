<?php
namespace Shkoliar\Ngrok\Plugin\Model;

use Shkoliar\Ngrok\Helper\Ngrok;
use Magento\Store\Model\BaseUrlChecker as Checker;

class BaseUrlChecker
{
    protected $ngrok;

    public function __construct(Ngrok $ngrok)
    {
        $this->ngrok = $ngrok;
    }

    /**
     * When use free ngrok, is necesary disable auto redirect in magento
     *
     * @param Checker $subject
     * @param [type] $result
     * @return void
     */
    public function afterIsEnabled(Checker $subject, $result)
    {
        return $this->ngrok->IsNgrokDomain() == true ? 0 : $result; 
    }

    /**
     * When use free ngrok, it share only domains unsecure,
     * this function change secure value only when use ngrok to unsecure to prevent loop redirect
     *
     * @param Checker $subject
     * @param [type] $result
     * @return void
     */
    public function afterIsFrontendSecure(Checker $subject, $result)
    {
        return $this->ngrok->IsNgrokDomain() == true ? 0 : $result; 
    }
}
