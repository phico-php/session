<?php

use Phico\Session\SessionStoreFactory;
use Phico\Session\Store\Redis;
use Phico\Session\Store\Filesystem;

$config = [

    'use' => '',

    'drivers' => [

        'files' => [
            'path' => 'tests/fixtures',
            'prefix' => '',
        ],

        'redis' => [
            'scheme' => 'tcp',
            'host' => '127.0.0.1',
            'port' => 6379,
            'prefix' => '',
        ],

    ],
];

test('can create a redis driver', function () use ($config) {
    $config['use'] = 'redis';
    $driver = SessionStoreFactory::create($config);

    expect($driver)->toBeInstanceOf(Redis::class);
});

test('can create a file driver', function () use ($config) {
    $config['use'] = 'files';
    $driver = SessionStoreFactory::create($config);

    expect($driver)->toBeInstanceOf(Filesystem::class);
});
