<?php

declare(strict_types=1);

namespace Phico\Session\Store;

use Phico\Cache\Drivers\Filesystem as Driver;
use Phico\Session\Session;


class Filesystem extends Driver implements StoreInterface
{
    use Traits\Create;
    use Traits\FetchOrCreate;
    use Traits\GenerateId;
    use Traits\Regenerate;


    public function fetch(string $id): Session
    {
        try {
            //@TODO this is never called, but would return a stale session if cron does not delete expired session files
            return new Session(
                $id,
                files($this->getKey($id))->read()
            );
        } catch (\Throwable $th) {
            throw new StoreException('Failed to fetch session from store', $th);
        }
    }
    public function store(Session $session): bool
    {
        try {
            files($this->getKey($session->id))->write((string) $session);
            return true;
        } catch (\Throwable $th) {
            throw new StoreException('Failed to save session in store', $th);
        }
    }
}
