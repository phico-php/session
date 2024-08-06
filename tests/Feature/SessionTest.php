<?php

use Phico\Session\Session;
use Phico\Session\Flash;

beforeEach(function () {

});

test('creates a new session with a given id', function () {
    $sessionId = 'session123';
    $session = new Session($sessionId);

    expect($session->id)->toBe($sessionId);
});

test('initializes with an empty data array and flash object', function () {
    $sessionId = 'session123';
    $session = new Session($sessionId);

    expect($session)->toBeInstanceOf(Session::class);
    expect($session->id)->toEqual($sessionId);
    expect($session)
        ->toHaveProperty('flash')
        ->toBeObject();
});

test('initializes with a payload and unserializes data and flash', function () {
    $sessionId = 'session123';
    $payload = serialize([
        'data' => ['key1' => 'value1'],
        'flash' => new Flash(),
    ]);

    $session = new Session($sessionId, $payload);

    expect($session->get('key1'))->toBe('value1');
});

test('serializes session data and flash object correctly', function () {
    $sessionId = 'session123';
    $session = new Session($sessionId);

    $serialized = (string) $session;

    expect(unserialize($serialized))->toBeArray();
});

test('allows setting and getting of data', function () {
    $sessionId = 'session123';
    $session = new Session($sessionId);

    $session->set('key', 'value');

    expect($session->get('key'))->toBe('value');
});

test('returns default value if key does not exist', function () {
    $sessionId = 'session123';
    $session = new Session($sessionId);

    $default = 'defaultValue';
    expect($session->get('nonExistentKey', $default))->toBe($default);
});

test('deletes session when delete method is called', function () {
    $sessionId = 'session123';
    $session = new Session($sessionId);

    $session->delete();

    expect($session->shouldDelete())->toBeTrue();
});

test('marks session for regeneration', function () {
    $sessionId = 'session123';
    $session = new Session($sessionId);

    $session->regenerate();

    expect($session->shouldRegenerate())->toBeTrue();
});

test('sets and retrieves flash data', function () {
    $sessionId = 'session123';
    $session = new Session($sessionId);

    $session->flash('flashKey', 'flashValue');

    expect($session->get('flashKey'))->toBeNull();

    $session = new Session($sessionId, (string) $session);

    expect($session->get('flashKey'))->toBe('flashValue');
});

test('checks if a key exists in the session data', function () {
    $sessionId = 'session123';
    $session = new Session($sessionId);

    $session->set('key', 'value');

    expect($session->has('key'))->toBeTrue();
    expect($session->has('nonExistentKey'))->toBeFalse();
});
