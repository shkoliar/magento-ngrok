<?php
namespace Shkoliar\Ngrok\Plugin\Session;

use Shkoliar\Ngrok\Helper\Ngrok;
use Magento\Framework\Session\Config;

class ConfigValue
{
    protected $ngrok;

    public function __construct(Ngrok $ngrok)
    {
        $this->ngrok = $ngrok;
    }

    public function afterSetCookieDomain(Config $subject, $result)
    {
       
        if ($this->ngrok->isNgrokDomain()) {
            $subject->setOption('session.cookie_domain', $this->ngrok->getDomain());
        }

        return $result;
    }
}
