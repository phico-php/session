<?php

declare(strict_types=1);

namespace Phico\Session\Store;

use Phico\Session\Session;


interface StoreInterface
{
    public function create(?string $payload = null): Session;
    public function delete(string $id): bool;
    public function exists(string $id): bool;
    public function fetch(string $id): Session;
    public function fetchOrCreate(null|string $id = null): Session;
    public function regenerate(Session $session): Session;
    public function store(Session $session): bool;
}
