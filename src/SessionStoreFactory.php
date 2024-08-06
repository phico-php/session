<?php

declare(strict_types=1);

namespace Phico\Session;

use Phico\Session\Store\{Filesystem, Redis, StoreInterface};


class SessionStoreFactory
{
    public static function create(array $config): StoreInterface
    {
        $use = strtolower($config['use']);

        return match (strtolower($use)) {
            'redis' => new Redis($config),
            'file', 'files', 'filesystem' => new Filesystem($config),
            default => throw new \InvalidArgumentException("Unsupported session store '$use'"),
        };
    }
}
