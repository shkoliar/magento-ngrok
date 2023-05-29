<?php declare(strict_types=1);

namespace Shkoliar\Ngrok\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Shkoliar\Ngrok\Api\Data\DomainInterface;

class Domain implements OptionSourceInterface
{
    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            DomainInterface::NGROK_IO => DomainInterface::NGROK_IO,
            DomainInterface::NGROK_APP => DomainInterface::NGROK_APP,
            DomainInterface::NGROK_DEV => DomainInterface::NGROK_DEV,
            DomainInterface::NGROK_FREE_APP => DomainInterface::NGROK_FREE_APP,
            DomainInterface::NGROK_FREE_DEV => DomainInterface::NGROK_FREE_DEV
        ];
    }
}