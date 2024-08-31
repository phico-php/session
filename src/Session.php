<?php

declare(strict_types=1);

namespace Phico\Session;

use Phico\DotAccess;


/**
 * @property string $id
 */
class Session
{
    use DotAccess;

    public readonly string $id;
    private array $data;
    private Flash $flash;
    private bool $delete;
    private bool $regenerate;


    public function __construct(string $id, ?string $payload = null)
    {
        $this->delete = false;
        $this->regenerate = false;

        $this->id = $id;
        $this->data = [];
        $this->flash = new Flash();

        if (!is_null($payload)) {
            $payload = unserialize($payload);
            $this->data = $payload['data'] ?? [];
            $this->flash = $payload['flash'] ?? new Flash();
        }

        $this->flash->age();
    }
    public function __toString(): string
    {
        return serialize([
            'data' => $this->data,
            'flash' => $this->flash
        ]);
    }
    public function __get(string $name): mixed
    {
        return $this->get($name);
    }
    public function __set(string $name, mixed $value): void
    {
        $this->set($name, $value);
    }
    public function __unset($name): void
    {
        $this->unset($name);
    }
    public function has(string $key): bool
    {
        return $this->dotHas('data', $key);
    }
    public function get(string $key, mixed $default = null): mixed
    {
        if ($this->flash->has($key)) {
            return $this->flash->get($key);
        }

        return $this->dotGet('data', $key, $default);
    }
    public function set(string $key, mixed $value): self
    {
        $this->dotSet('data', $key, $value);
        return $this;
    }
    public function unset(string $key): self
    {
        $this->dotUnset('data', $key);
        return $this;
    }
    public function delete(): self
    {
        $this->delete = true;
        return $this;
    }
    public function flash(array|string $key, mixed $value = null): self
    {
        if (is_string($key)) {
            $this->flash->set($key, $value);
        }
        if (is_array($key)) {
            if (!is_null($value)) {
                throw new \InvalidArgumentException('Session flash() cannot accept two arguments if the first argument is an array');
            }
            foreach ($key as $k => $v) {
                $this->flash->set($k, $v);
            }
        }

        return $this;
    }
    public function regenerate(): self
    {
        $this->regenerate = true;
        return $this;
    }
    public function shouldDelete(): bool
    {
        return $this->delete;
    }
    public function shouldRegenerate(): bool
    {
        return $this->regenerate;
    }
}
