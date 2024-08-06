<?php

declare(strict_types=1);

namespace Phico\Session\Store;

use Phico\PhicoException;


class StoreException extends PhicoException
{
    public function __construct(string $message = "", \Throwable $previous = null)
    {
        $this->message = $message;
        $this->previous = $previous;
    }
}
