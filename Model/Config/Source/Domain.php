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
            [
                'label' => DomainInterface::NGROK_IO, 'value' => DomainInterface::NGROK_IO
            ],
            [
                'label' => DomainInterface::NGROK_APP, 'value' => DomainInterface::NGROK_APP
            ],
            [
                'label' => DomainInterface::NGROK_DEV, 'value' => DomainInterface::NGROK_DEV
            ],
            [
                'label' => DomainInterface::NGROK_FREE_APP, 'value' => DomainInterface::NGROK_FREE_APP
            ],
            [
                'label' => DomainInterface::NGROK_FREE_DEV, 'value' => DomainInterface::NGROK_FREE_DEV
            ]
        ];
    }
}