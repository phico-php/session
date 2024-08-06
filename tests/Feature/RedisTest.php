<?php

use Phico\Session\Store\Redis;

beforeEach(function () {
    $this->driver = new Redis(['host' => '127.0.0.1', 'port' => 6379, 'prefix' => 'session-test']);
});

test('can set and get a value in redis cache', function () {
    $this->driver->set('foo', 'bar');
    expect($this->driver->get('foo'))->toBe('bar');
});

test('returns default value if key does not exist in redis cache', function () {
    expect($this->driver->get('bar', 'default'))->toBe('default');
});

test('can delete a value in redis cache', function () {
    expect($this->driver->delete('foo'))->toBeTrue();
});
