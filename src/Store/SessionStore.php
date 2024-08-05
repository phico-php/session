<?php

declare(strict_types=1);

namespace Phico\Session\Store;

use Phico\Session\Session;


interface SessionStore
{
    public function create(?string $payload = null): Session;
    public function delete(string $id): void;
    public function exists(string $id): bool;
    public function fetch(string $id): Session;
    public function regenerate(Session $session): Session;
    public function store(Session $session): void;
}
