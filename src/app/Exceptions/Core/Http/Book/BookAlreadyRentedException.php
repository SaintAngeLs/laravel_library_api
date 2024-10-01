<?php

namespace App\Exceptions\Http;

use Exception;

class BookAlreadyRentedException extends Exception
{
    protected $message = 'This book is already rented.';
    protected $code = 400;

    public function __construct($message = null)
    {
        parent::__construct($message ?? $this->message, $this->code);
    }
}
