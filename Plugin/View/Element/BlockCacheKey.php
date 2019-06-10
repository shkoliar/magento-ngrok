<?php
/**
 * BlockCacheKey
 *
 * @copyright Copyright © 2019 Dmitry Shkoliar. All rights reserved.
 * @author    dmitry@shkoliar.com
 */

namespace Shkoliar\Ngrok\Plugin\View\Element;

use Shkoliar\Ngrok\Helper\Ngrok;
use Magento\Framework\View\Element\AbstractBlock;

/**
 * Class BlockCacheKey
 * Should modify cache key for block_html cache with taking in count domain name and protocol
 */
class BlockCacheKey
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
     * Modifies cache key for block_html cache with taking in count domain name and protocol
     *
     * @param AbstractBlock $subject    Intercepted object of \Magento\Framework\View\Element\AbstractBlock class
     * @param string $result            Key for caching block content
     *
     * @return string
     */
    public function afterGetCacheKey(AbstractBlock $subject, $result)
    {
        $ngrokDomain = $this->ngrok->getDomain();

        if ($ngrokDomain) {
            $protocol = $this->ngrok->getProtocol();

            $hash = $subject::CACHE_KEY_PREFIX . sha1($result . $protocol . $ngrokDomain);

            return $hash;
        }

        return $result;
    }


}