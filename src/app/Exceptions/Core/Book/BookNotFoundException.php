<?php

namespace App\Exceptions\Core\Book;

use Exception;

class BookNotFoundException extends Exception
{
    protected $message = "The book was not found.";

    public function __construct($message = null)
    {
        parent::__construct($message ?? $this->message);
    }
}
