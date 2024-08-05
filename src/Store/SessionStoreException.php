<?php

declare(strict_types=1);

namespace Phico\Session\Store;

use Phico\PhicoException;


class SessionStoreException extends PhicoException
{
    public function __construct(string $message = "", \Throwable $previous = null)
    {
        $this->message = $message;
        $this->previous = $previous;
    }
}
