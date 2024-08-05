<?php

declare(strict_types=1);

namespace Phico\Session;

use Phico\Http\Request;
use Phico\Middleware\MiddlewareInterface;
use Phico\Session\Store\SessionStore;


class SessionMiddleware implements MiddlewareInterface
{
    private string $cookie_name;
    private array $cookie_options;
    private SessionStore $store;


    public function __construct(SessionStore $store, array $config)
    {
        $this->store = $store;

        // fetch config values
        $this->cookie_name = $config['name'];
        $this->cookie_options = array_merge([
            'expires' => 0,
            'path' => '/',
            'domain' => '',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict',
            'prefix' => '',
            'encode' => false,
        ], $config['options']);
    }

    public function handle(Request $request, $next)
    {
        if ($request->attrs->has('session')) {
            throw new \DomainException('Session middleware has been included twice, please check your middleware stack');
        }

        // get session id from cookie
        $id = $request->cookies->get($this->cookie_name);
        // fetch existing session or create a new one
        $session = $this->store->fetchOrCreate($id);
        // store session in request attributes
        $request->attrs->set('session', $session);

        // continue app
        $response = $next($request);

        // return response if session is deleted
        if ($session->shouldDelete()) {
            $this->store->delete($session->id);
            return $response;
        }

        // regenerated session will be saved below
        if ($session->shouldRegenerate()) {
            $session = $this->store->regenerate($session);
        }

        // save session and set cookie
        if ($this->store->store($session)) {
            $response->cookie($this->cookie_name, $session->id, $this->cookie_options);
        }

        return $response;
    }
}
