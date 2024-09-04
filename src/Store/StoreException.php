<?php

declare(strict_types=1);

namespace Phico\Session\Store;

use Throwable;
use Phico\PhicoException;


class StoreException extends PhicoException
{
    /**
     * @var string
     */
    protected $message = "";
    /**
     * @var ?Throwable
     */
    private $previous = null;

    public function __construct(string $message = "", Throwable $previous = null)
    {
        $this->message = $message;
        $this->previous = $previous;
    }
}
