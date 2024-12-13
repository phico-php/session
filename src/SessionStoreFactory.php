<?php

declare(strict_types=1);

namespace Phico\Session;

use InvalidArgumentException;
use Phico\Session\Store\{Filesystem, Redis, StoreInterface};

/**
 * Creates Session Stores
 * @package Phico\Session
 */
class SessionStoreFactory
{
    /**
     * Returns a new Session store
     * @param array $config
     * @return StoreInterface
     * @throws InvalidArgumentException
     */
    public static function create(array $config): StoreInterface
    {
        $use = strtolower($config['use']);
        $config = array_merge($config['stores'][$use], [
            'ttl' => $config['ttl'] ?? 3600
        ]);

        return match (strtolower($use)) {
            'redis' => new Redis($config),
            'file', 'files', 'filesystem' => new Filesystem($config),
            default => throw new \InvalidArgumentException("Unsupported session store '$use'"),
        };
    }
}
