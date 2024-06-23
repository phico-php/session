<?php

declare(strict_types=1);

namespace Phico\Session\Store;


class KeyDB implements StoreInterface
{
    protected string $account_id;
    protected string $namespace_id;
    protected string $url;


    public function __construct()
    {
        $this->url = config('api.kv.url');
        $this->account_id = config('api.kv.account_id');
        $this->namespace_id = config('api.kv.namespace_id');
    }

    public function get(string $key): mixed
    {
        // json_decode
    }
    public function put(string $key, mixed $value): void
    {
        $value = json_encode($value);

    }
}
