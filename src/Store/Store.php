<?php

declare(strict_types=1);

namespace Phico\Session\Store;

use Phico\Session\Session;


abstract class Store
{
    public function create(?string $payload = null): Session
    {
        return new Session($this->generateId(), $payload);
    }
    public function fetchOrCreate(string $id): Session
    {
        try {

            if ($this->exists($id)) {
                return $this->fetch($id);
            }

            return $this->create();

        } catch (\Throwable $th) {
            throw new SessionStoreException('Failed to fetch session from store', $th);
        }
    }
    public function regenerate(Session $session): Session
    {
        $this->delete($session->id);
        return $this->create((string) $session);
    }
    protected function generateId(): string
    {
        do {
            $id = bin2hex(openssl_random_pseudo_bytes(32 / 2));
        } while ($this->exists($id));

        return $id;
    }
}
