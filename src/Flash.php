<?php

declare(strict_types=1);

namespace Phico\Session;

use Phico\DotAccess;

/**
 * Handles flash messages in the session
 * @package Phico\Session
 */
class Flash
{
    use DotAccess;

    /**
     * Holds the current session data
     * @var array
     */
    private array $current;
    /**
     * Holds the next session data
     * @var array
     */
    private array $next;

    /**
     * The constructor accepts an array of data
     * @param array $data
     * @return void
     */
    public function __construct(array $data = [])
    {
        $this->current = $data['current'] ?? [];
        $this->next = $data['next'] ?? [];
    }

    /**
     * Ages the flash by replacing current with next.
     * @return Flash
     */
    public function age(): self
    {
        $this->current = $this->next;
        $this->next = [];

        return $this;
    }

    /**
     * Returns true if the current session data contains a matching key
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($this->current[$key]);
    }

    /**
     * Returns the value identified by key, or a default if not set
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->dotGet($this->current, $key, $default);
    }

    /**
     * Sets a value by key
     * @param string $key
     * @param mixed $value
     * @return Flash
     */
    public function set(string $key, mixed $value): self
    {
        $this->dotSet($this->next, $key, $value);
        return $this;
    }
}
