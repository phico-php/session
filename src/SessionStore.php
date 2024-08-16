<?php

declare(strict_types=1);

namespace Phico\Session;

use Phico\Cache\Cache;
use Phico\Session\Store\StoreInterface;


class SessionStore extends Cache
{
    protected StoreInterface $store;


    public function __construct(array $config)
    {
        $this->store = SessionStoreFactory::create($config);
    }
    public function create(?string $payload = null): Session
    {
        return $this->store->create($payload);
    }
    public function delete(string $id): bool
    {
        return $this->store->delete($id);
    }
    public function exists(string $id): bool
    {
        return $this->store->exists($id);
    }
    public function fetch(string $id): Session
    {
        return $this->store->fetch($id);
    }
    public function fetchOrCreate(null|string $id = null): Session
    {
        return $this->store->fetchOrCreate($id);
    }
    public function regenerate(Session $session): Session
    {
        return $this->store->regenerate($session);
    }
    public function store(Session $session): bool
    {
        return $this->store->store($session);
    }
}
