<?php

declare(strict_types=1);

namespace Phico\Session\Store\Traits;

use Phico\Session\Session;
use Phico\Session\Store\StoreException;


trait fetchOrCreate
{
    public function fetchOrCreate(string $id): Session
    {
        try {

            if ($this->exists($id)) {
                return $this->fetch($id);
            }

            return $this->create();

        } catch (\Throwable $th) {
            throw new StoreException('Failed to fetch session from store', $th);
        }
    }
}
