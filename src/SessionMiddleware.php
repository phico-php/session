<?php

declare(strict_types=1);

namespace Phico\Session;

use Phico\Http\Request;
use Phico\Middleware\MiddlewareInterface;

class SessionMiddleware implements MiddlewareInterface
{
    function handle(Request $request, $next)
    {
        // don't clobber an existing session
        if ($request->attrs->get('session') instanceof Session) {
            return $next($request);
        }

        // fetch config values
        $cookie_name = config()->get('session.cookie.name', 'session');
        $cookie_options = array_merge([
            'expires' => 0,
            'path' => '/',
            'domain' => '',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict',
            'prefix' => '',
            'encode' => false,
        ], config()->get('session.cookie.options'));

        // fetch existing session or create a new one
        $session = new Session($request->cookies->get($cookie_name));
        // store session in request attributes
        $request->attrs->set('session', $session);

        // continue app
        $response = $next($request);

        // save session and set cookie
        if ($session->save()) {
            $response->cookie($cookie_name, $session->id, $cookie_options);
        }

        return $response;
    }
}
