<?php

declare(strict_types=1);

namespace Phico\Session\Store\Traits;

use Phico\Session\Session;


trait Create
{
    public function create(?string $payload = null): Session
    {
        return new Session($this->generateId(), $payload);
    }

}
