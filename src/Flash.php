<?php

declare(strict_types=1);

namespace Phico\Session;

use Phico\DotAccess;


class Flash
{
    use DotAccess;

    private array $current;
    private array $next;


    public function __construct(array $data = [])
    {
        $this->current = $data['current'] ?? [];
        $this->next = $data['next'] ?? [];
    }
    public function age(): self
    {
        $this->current = $this->next;
        $this->next = [];

        return $this;
    }
    public function has(string $key): bool
    {
        return isset($this->current[$key]);
    }
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->dotGet('current', $key, $default);
    }
    public function set(string $key, mixed $value): self
    {
        $this->dotSet('next', $key, $value);
        return $this;
    }
}
