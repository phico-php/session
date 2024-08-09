<?php

declare(strict_types=1);

namespace Phico\Session\Store;

use Phico\Cache\Drivers\Redis as Driver;
use Phico\Session\Session;


class Redis extends Driver implements StoreInterface
{
    use Traits\Create;
    use Traits\FetchOrCreate;
    use Traits\GenerateId;
    use Traits\Regenerate;


    public function fetch(string $id): Session
    {
        try {
            return new Session(
                $id,
                $this->client->get($this->getKey($id))
            );
        } catch (\Throwable $th) {
            throw new StoreException('Failed to fetch session from store', $th);
        }
    }
    public function store(Session $session): bool
    {
        try {
            $this->client->setEx($this->getKey($session->id), $this->ttl, (string) $session);
            return true;
        } catch (\Throwable $th) {
            throw new StoreException('Failed to save session in store', $th);
        }
    }
}
