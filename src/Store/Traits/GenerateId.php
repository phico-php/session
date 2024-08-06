<?php

declare(strict_types=1);

namespace Phico\Session\Store\Traits;


trait GenerateId
{
    protected function generateId(): string
    {
        do {
            $id = bin2hex(openssl_random_pseudo_bytes(32 / 2));
        } while ($this->exists($id));

        return $id;
    }
}
