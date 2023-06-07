<?php declare(strict_types=1);

namespace Shkoliar\Ngrok\Api\Data;

interface DomainInterface
{
    public const NGROK_IO = '.ngrok.io';

    public const NGROK_APP = '.ngrok.app';

    public const NGROK_DEV = '.ngrok.dev';

    public const NGROK_FREE_APP = '.ngrok-free.app';

    public const NGROK_FREE_DEV = '.ngrok-free.dev';
}