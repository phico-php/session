<?php

declare(strict_types=1);

namespace Phico\Session\Store\Traits;

use Phico\Session\Session;
use Phico\Session\Store\StoreException;


trait FetchOrCreate
{
    public function fetchOrCreate(null|string $id = null): Session
    {
        try {

            if (is_null($id) or !$this->exists($id)) {
                return $this->create();
            }

            return $this->fetch($id);

        } catch (\Throwable $th) {
            throw new StoreException('Failed to fetch session from store', $th);
        }
    }
}
