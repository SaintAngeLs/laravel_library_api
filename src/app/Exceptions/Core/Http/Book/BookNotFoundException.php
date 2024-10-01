<?php

namespace App\Exceptions\Http\Book;

use Exception;

class BookNotFoundException extends Exception
{
    protected $message = 'The book was not found.';
    protected $code = 404;

    public function __construct($message = null)
    {
        parent::__construct($message ?? $this->message, $this->code);
    }
}
