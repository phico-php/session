<?php

declare(strict_types=1);

namespace Phico\Session\Store;


class File implements StoreInterface
{
    protected string $path;


    public function __construct()
    {
        $this->path = config('session.file.folder', 'storage/sessions');
    }
    public function delete(string $id): void
    {
        files()->delete(path("$this->path/$id"));
    }
    public function exists(string $id): bool
    {
        return files()->exists(path("$this->path/$id"));
    }
    public function get(string $id): ?array
    {
        if (!$this->exists($id)) {
            return null;
        }
        return (array) json_decode(files()->read(path("$this->path/$id")));
    }
    public function put(string $id, array $data): void
    {
        files()->write(path("$this->path/$id"), json_encode($data));
    }
}
