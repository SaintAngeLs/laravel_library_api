<?php

namespace App\Exceptions\Http\Client;

use Exception;

class ClientNotFoundException extends Exception
{
    protected $message = 'Client not found.';
    protected $code = 404;

    public function __construct($message = null)
    {
        parent::__construct($message ?? $this->message, $this->code);
    }
}
