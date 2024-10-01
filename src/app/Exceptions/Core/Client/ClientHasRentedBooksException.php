<?php

namespace App\Exceptions\Core\Client;

use Exception;

class ClientHasRentedBooksException extends Exception
{
    protected $message = "Client cannot be deleted as they have rented books.";

    public function __construct($message = null)
    {
        parent::__construct($message ?? $this->message);
    }
}
