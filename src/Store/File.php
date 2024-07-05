<?php

declare(strict_types=1);

namespace Phico\Session\Store;


class File implements StoreInterface
{
    protected string $path;


    public function __construct()
    {
        $this->path = config()->get('session.file.folder', 'storage/sessions');
    }
    public function delete(string $id): void
    {
        files(path("$this->path/$id"))->delete();
    }
    public function exists(string $id): bool
    {
        return files(path("$this->path/$id"))->exists();
    }
    public function get(string $id): ?array
    {
        if (!$this->exists($id)) {
            return null;
        }
        return unserialize(files(path("$this->path/$id"))->read());
    }
    public function put(string $id, array $data): void
    {
        files(path("$this->path/$id"))->write(serialize($data));
    }
}
