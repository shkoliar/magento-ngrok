<?php declare(strict_types=1);

namespace Shkoliar\Ngrok\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    private const XML_IS_CUSTOM_DOMAIN = 'ngrok/general/enable_custom_domain';
    private const XML_DOMAIN = 'ngrok/general/domain';
    private const XML_CUSTOM_DOMAIN = 'ngrok/general/custom_domain';

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        private ScopeConfigInterface $scopeConfig
    ) {}

    /**
     * @return bool
     */
    public function isCustomDomainEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_IS_CUSTOM_DOMAIN
        );
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_DOMAIN
        );
    }

    /**
     * @return string
     */
    public function getCustomDomain(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_CUSTOM_DOMAIN
        );
    }
}