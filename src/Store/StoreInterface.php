<?php

declare(strict_types=1);

namespace Phico\Session\Store;


interface StoreInterface
{
    public function delete(string $id): void;
    public function exists(string $id): bool;
    public function get(string $id): ?array;
    public function put(string $id, array $data): void;
}
