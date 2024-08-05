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
    public function regenerate(Session $session): Session
    {
        $this->delete($session);
        return $this->create($session->toString());
    }
    protected function generateId(): string
    {
        do {
            $id = bin2hex(openssl_random_pseudo_bytes(32 / 2));
        } while ($this->exists($id));

        return $id;
    }
}
