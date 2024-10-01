<?php

namespace App\Exceptions\Core\Book;

use Exception;

class BookNotRentedException extends Exception
{
    protected $message = "The book is not rented.";

    public function __construct($message = null)
    {
        parent::__construct($message ?? $this->message);
    }
}
