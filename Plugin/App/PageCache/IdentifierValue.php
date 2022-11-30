<?php
/**
 * IdentifierValue
 *
 * @copyright Copyright © 2021 Dmitry Shkoliar. All rights reserved.
 * @author    dmitry@shkoliar.com
 */

namespace Shkoliar\Ngrok\Plugin\App\PageCache;

use Shkoliar\Ngrok\Helper\Ngrok;
use Magento\Framework\App\PageCache\Identifier;

/**
 * Class IdentifierValue
 * Should modify identifier for a built-in cache with taking into account domain name and protocol
 */
class IdentifierValue
{
    /**
     * @var Ngrok
     */
    protected $ngrok;

    /**
     * @param Ngrok $ngrok
     */
    public function __construct(Ngrok $ngrok)
    {
        $this->ngrok = $ngrok;
    }

    /**
     * Modifies identifier for a built-in cache with taking into account domain name and protocol
     *
     * @param Identifier $subject   Intercepted object of \Magento\Framework\App\PageCache\Identifier class
     * @param string $result        Unique page identifier
     *
     * @return string
     */
    public function afterGetValue(Identifier $subject, $result)
    {
        if ($this->ngrok->isNgrokDomain()) {
            $ngrokDomain = $this->ngrok->getDomain();
            $protocol = $this->ngrok->getProtocol();
            return sha1($protocol . $ngrokDomain . $result);
        }

        return $result;
    }
}
