<?php

declare(strict_types=1);

namespace Phico\Session\Store;


interface SessionStore
{
    public function delete(string $id): void;
    public function exists(string $id): bool;
    public function get(string $id): ?string;
    public function put(string $id, string $data): void;
}
