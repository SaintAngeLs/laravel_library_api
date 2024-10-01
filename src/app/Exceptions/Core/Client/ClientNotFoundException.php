<?php

namespace App\Exceptions\Core\Client;

use Exception;

class ClientNotFoundException extends Exception
{
    protected $message = "Client not found.";

    public function __construct($message = null)
    {
        parent::__construct($message ?? $this->message);
    }
}
