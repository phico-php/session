<?php

declare(strict_types=1);

namespace Phico\Session\Store;

use Phico\Session\Session;


class File extends Store implements SessionStore
{
    protected string $path;
    protected int $ttl;


    public function __construct(string $path, int $ttl)
    {
        $this->path = $path;
        $this->ttl = $ttl;
    }
    public function create(string|null $payload = null): Session
    {
        $session = parent::create($payload);
        files(path("$this->path/$session->id"))->create();

        return $session;
    }
    public function delete(string $id): bool
    {
        try {
            files(path("$this->path/$id"))->delete();
            return true;
        } catch (\Throwable $th) {
            throw new SessionStoreException('Failed to delete session from store', $th);
        }
    }
    public function exists(string $id): bool
    {
        try {
            return files(path("$this->path/$id"))->exists();
        } catch (\Throwable $th) {
            throw new SessionStoreException('Failed to check session exists in store', $th);
        }
    }
    public function fetch(string $id): Session
    {
        try {
            return new Session(
                $id,
                files(path("$this->path/$id"))->read()
            );
        } catch (\Throwable $th) {
            throw new SessionStoreException('Failed to fetch session from store', $th);
        }
    }
    public function store(Session $session): bool
    {
        try {
            files(path("$this->path/$session->id"))->write((string) $session);
            return true;
        } catch (\Throwable $th) {
            throw new SessionStoreException('Failed to save session in store', $th);
        }
    }
}
