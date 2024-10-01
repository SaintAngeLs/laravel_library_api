<?php

namespace App\Exceptions\Http\Client;

use Exception;

class ClientHasRentedBooksException extends Exception
{
    protected $message = 'Client cannot be deleted because they have rented books.';
    protected $code = 400;

    public function __construct($message = null)
    {
        parent::__construct($message ?? $this->message, $this->code);
    }
}
