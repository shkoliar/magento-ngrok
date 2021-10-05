<?php
/**
 * StoreBaseUrl
 *
 * @copyright Copyright © 2021 Dmitry Shkoliar. All rights reserved.
 * @author    dmitry@shkoliar.com
 */

namespace Shkoliar\Ngrok\Plugin\Model;

use Shkoliar\Ngrok\Helper\Ngrok;
use Magento\Store\Model\Store;

/**
 * Class StoreBaseUrl
 * Should replace base urls with ngrok domain name and protocol (only if needed)
 */
class StoreBaseUrl
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
     * Replaces base url with ngrok domain name and protocol (only if needed)
     *
     * @param Store $subject    Intercepted object of \Magento\Store\Model\Store class
     * @param string $result    Retrieved base URL
     *
     * @return string
     */
    public function afterGetBaseUrl(Store $subject, $result)
    {
        $defaultBaseUrls = [
            $subject->getConfig($subject::XML_PATH_SECURE_BASE_URL),
            $subject->getConfig($subject::XML_PATH_UNSECURE_BASE_URL)
        ];

        if (in_array($result, $defaultBaseUrls) && $ngrokDomain = $this->ngrok->getDomain()) {
            $protocol = $this->ngrok->getProtocol();

            return $protocol . $ngrokDomain . DIRECTORY_SEPARATOR;
        }

        return $result;
    }
}
