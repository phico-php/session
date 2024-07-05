<?php

declare(strict_types=1);

namespace Phico\Session;

use Phico\PhicoException;
use Phico\Session\Store\File;

/**
 * @property string $id
 */
class Session
{
    private string $id;
    private array $data;
    private Flash $flash;
    private $store;


    public function __construct(?string $id = null)
    {
        // setup session store (@TODO Interface, DI)
        $this->store = new File();

        // if no id, create a new session
        if (is_null($id) or empty($id)) {
            $this->create();
            return;
        }
        // if we have an id then look it up
        $encoded = $this->store->get($id);
        // if null then no session was found so create a new one
        if (is_null($encoded)) {
            $this->create();
            return;
        }
        // populate session data from storage
        $this->id = $id;
        $this->data = $encoded['data'];
        $this->flash = $encoded['flash'];
        $this->flash->age();
    }
    public function __get(string $name): mixed
    {
        if ($name !== "id") {
            throw new PhicoException("Cannot access unknown property $name");
        }

        return $this->$name;
    }
    public function delete(): void
    {
        // remove data from persistence
        $this->store->delete($this->id);
        // clear id, middleware will no longer save the session
        $this->id = '';
        // clear data and flash
        $this->data = [];
        $this->flash = new Flash;
    }
    public function flash(string $key, mixed $value): self
    {
        $this->flash->set($key, $value);
        return $this;
    }
    public function get(string $key, mixed $default = null): mixed
    {
        if ($this->flash->has($key)) {
            return $this->flash->get($key);
        }

        return $this->data[$key] ?? $default;
    }
    public function has(string $key): bool
    {
        return isset($this->data[$key]);
    }
    public function set(string $key, mixed $value): self
    {
        $this->data[$key] = $value;
        return $this;
    }
    public function regenerate(): self
    {
        // save old id
        $old_id = $this->id;
        // generate a new id
        $this->id = $this->generateId();
        // store current data under new id
        $this->store->put($this->id, [
            'data' => $this->data,
            'flash' => $this->flash
        ]);
        // remove data stored under old id
        $this->store->delete($old_id);

        return $this;
    }
    public function save(): bool
    {
        // only save if we have an id
        if (empty($this->id)) {
            return false;
        }
        // store data with id
        $this->store->put($this->id, [
            'data' => $this->data,
            'flash' => $this->flash
        ]);

        return true;
    }
    private function create()
    {
        // init data structs
        $this->data = [];
        $this->flash = new Flash();
        // generate a new id
        $this->id = $this->generateId();
    }
    private function generateId(): string
    {
        do {
            $id = bin2hex(openssl_random_pseudo_bytes(32 / 2));
        } while ($this->store->exists($id));

        return $id;
    }
}
