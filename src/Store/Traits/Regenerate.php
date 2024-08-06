<?php

declare(strict_types=1);

namespace Phico\Session\Store\Traits;

use Phico\Session\Session;


trait Regenerate
{
    public function regenerate(Session $session): Session
    {
        $this->delete($session->id);
        return $this->create((string) $session);
    }
}
