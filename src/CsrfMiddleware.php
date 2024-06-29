<?php

declare(strict_types=1);

namespace Phico\Session;

use Phico\Http\{HttpException, Request};
use Phico\Middleware\MiddlewareInterface;

class CsrfMiddleware implements MiddlewareInterface
{
    function handle(Request $request, $next)
    {
        $session = $request->attrs->get('session');
        if (is_null($session)) {
            throw new \LogicException('CsrfMiddleware cannot find the session, place it after the SessionMiddleware');
        }

        // get csrf input field name from config
        $token_name = config()->get('session.csrf.token_name', '__csrf_token');

        if ($request->is('get')) {
            // if request method is GET, then set the token in session
            $session->set($token_name, md5((string) (rand(1, 999999) * rand(1, 999999))));
            $session->set('__csrf_token_name', $token_name);
        } else {
            // else compare the input token to session
            if ($session->get($token_name) !== $request->body->get($token_name)) {
                throw new HttpException('Token mismatch', 403);
            }
        }

        // continue app
        $response = $next($request);

        return $response;
    }
}
