<?php

declare(strict_types=1);

namespace Phico\Session\Store;

use Phico\Cache\Cache as Driver;
use Phico\Session\Session;


class Redis extends Store implements SessionStore
{
    protected Driver $driver;
    protected string $prefix;
    protected int $ttl;


    public function __construct(Driver $driver, array $config)
    {
        $this->driver = $driver;
        $this->prefix = $config['prefix'] ?? 'session';
        $this->ttl = $config['ttl'] ?? 3600;
    }
    protected function getKey(string $id): string
    {
        return "{$this->prefix}.{$id}";
    }

    public function delete(string $id): bool
    {
        try {
            $this->driver->del($this->getKey($id));
            return true;
        } catch (\Throwable $th) {
            throw new SessionStoreException('Failed to delete session from store', $th);
        }
    }
    public function exists(string $id): bool
    {
        try {
            return $this->driver->exists($this->getKey($id));
        } catch (\Throwable $th) {
            throw new SessionStoreException('Failed to check session exists in store', $th);
        }
    }
    public function fetch(string $id): Session
    {
        try {
            return new Session(
                $id,
                $this->driver->get($this->getKey($id))
            );
        } catch (\Throwable $th) {
            throw new SessionStoreException('Failed to fetch session from store', $th);
        }
    }
    public function store(Session $session): bool
    {
        try {
            $this->driver->set($this->getKey($session->id));
            return true;
        } catch (\Throwable $th) {
            throw new SessionStoreException('Failed to save session in store', $th);
        }
    }
}
