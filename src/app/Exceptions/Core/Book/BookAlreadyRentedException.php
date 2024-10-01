<?php

namespace App\Exceptions\Core\Book;

use Exception;

class BookAlreadyRentedException extends Exception
{
    protected $message = "The book is already rented.";

    public function __construct($message = null)
    {
        parent::__construct($message ?? $this->message);
    }
}
