<?php
/**
 * Ngrok
 *
 * @copyright Copyright © 2021 Dmitry Shkoliar. All rights reserved.
 * @author    dmitry@shkoliar.com
 */

namespace Shkoliar\Ngrok\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Shkoliar\Ngrok\Model\Config;

class Ngrok extends AbstractHelper
{
    const SCHEME_HTTP  = 'http';
    const SCHEME_HTTPS = 'https';

    const HTTP_X_FORWARDED_PROTO = 'HTTP_X_FORWARDED_PROTO';

    /**
     * @param Config $config
     */
    public function __construct(
        private Config $config
    ) {}

    /**
     * Get server parameter value by key
     *
     * @param $key string
     *
     * @return string
     */
    protected function getServer($key)
    {
        return $this->_request->getServer($key, '');
    }

    /**
     * Get Ngrok Domain
     *
     * @return string
     */
    public function getDomain()
    {
        $ngrokDomain = $this->getServer('HTTP_X_ORIGINAL_HOST') ?: $this->getServer('HTTP_HOST');

        if ($this->config->isCustomDomain()) {
            $configuredNgrokDomain = $this->config->getCustomDomain();
        } else {
            $configuredNgrokDomain = $this->config->getDomain();
        }

        return stripos($ngrokDomain, $configuredNgrokDomain) !== false ? $ngrokDomain : false;
    }

    /**
    * Fix PHP 8.1
    * return bool 
    */   
    public function IsNgrokDomain() : bool
    {
        return $this->getDomain() != false ? true : false;
    }

    /**
     * Returns whether request was delivered over HTTPS
     *
     * @return bool
     */
    public function isSecure()
    {
        $isRequestSecure = $this->_request->isSecure();

        if (!$isRequestSecure) { // fix for older Magento versions
            $isRequestSecure = stripos(
                $this->getServer(self::HTTP_X_FORWARDED_PROTO),
                self::SCHEME_HTTPS
            ) === 0;
        }

        return $isRequestSecure;
    }

    /**
     * Get Protocol
     *
     * @return string
     */
    public function getProtocol()
    {
        $isRequestSecure = $this->isSecure();

        return ($isRequestSecure ? self::SCHEME_HTTPS : self::SCHEME_HTTP) . '://';
    }
}
