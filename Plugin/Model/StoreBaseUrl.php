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
        if($this->ngrok->IsNgrokDomain()){

            $ngrokDomain = $this->ngrok->getDomain();
            
            $defaultBaseUrls = [
                $subject->getConfig($subject::XML_PATH_SECURE_BASE_URL),
                $subject->getConfig($subject::XML_PATH_UNSECURE_BASE_URL)
            ];
    
            if (in_array($result, $defaultBaseUrls)) {
                $protocol = $this->ngrok->getProtocol();
    
                return $protocol . $ngrokDomain . $this->getPath($result);
            }
        

            /* Media URL Base */
            $mediaBaseUrls = [
                $subject->getConfig($subject::XML_PATH_SECURE_BASE_MEDIA_URL),
                $subject->getConfig($subject::XML_PATH_UNSECURE_BASE_MEDIA_URL)
            ];

            if (in_array($result, $mediaBaseUrls)) {
                $protocol = $this->ngrok->getProtocol();
                return $protocol . $ngrokDomain . $this->getSegmentPath($result, $defaultBaseUrls[1], 'media/');
            }


            /* Static URL Base */
            $staticBaseUrls = [
                $subject->getConfig($subject::XML_PATH_SECURE_BASE_STATIC_URL),
                $subject->getConfig($subject::XML_PATH_UNSECURE_BASE_STATIC_URL)
            ];

            if (in_array($result, $staticBaseUrls)) {
                $protocol = $this->ngrok->getProtocol();
                return $protocol . $ngrokDomain . $this->getSegmentPath($result, $defaultBaseUrls[1], 'static/');
            }
        }

        return $result;
    }

    /**
     * Path of the URL including leading and trailing slash
     *
     * @param string $url
     *
     * @return string
     */
    private function getPath($url)
    {
        return (string)parse_url((string)$url, PHP_URL_PATH) ?: '/';
    }

    /**
     * Path of a media or static URL, relative to the installation directory of the store
     *
     * @param string $url         Retrieved URL
     * @param string $baseUrl     Default base URL of the store
     * @param string $segment     Trailing path segment, e.g. "media/"
     *
     * @return string
     */
    private function getSegmentPath($url, $baseUrl, $segment)
    {
        $path = $this->getPath($url);

        return substr($path, -strlen('/' . $segment)) === '/' . $segment
            ? $path
            : $this->getPath($baseUrl) . $segment;
    }

    /**
     *  When use free ngrok is necesary change to unsecure frontend urls to prevent loop redirect
     */
    public function afterIsUrlSecure(Store $subject, $result)
    {
        return $this->ngrok->IsNgrokDomain() == true ? 0 : $result; 
    }
}
