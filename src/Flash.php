<?php

declare(strict_types=1);

namespace Phico\Session;


class Flash
{
    private array $current;
    private array $next;


    public function __construct(array $data = [])
    {
        $this->current = $data['next'] ?? [];
        $this->next = [];
    }
    public function has(string $key): bool
    {
        return isset($this->current[$key]);
    }
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->current[$key] ?? $default;
    }
    public function set(string $key, mixed $value): self
    {
        $this->next[$key] = $value;
        return $this;
    }
    public function __toString()
    {
        return json_encode([
            'current' => $this->current,
            'next' => $this->next
        ]);
    }
}
