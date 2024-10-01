<?php

namespace App\Exceptions\Http\Book;

use Exception;

/**
 * @OA\Schema(
 *     schema="BookAlreadyRentedException",
 *     title="BookAlreadyRentedException",
 *     description="Exception thrown when a book is already rented",
 *     type="object",
 *     required={"message", "code"},
 *     @OA\Property(
 *         property="message",
 *         type="string",
 *         description="Exception message"
 *     ),
 *     @OA\Property(
 *         property="code",
 *         type="integer",
 *         description="HTTP status code"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         description="HTTP error status"
 *     )
 * )
 */
class BookAlreadyRentedException extends Exception
{
    protected $message = 'This book is already rented.';
    protected $code = 400;

    public function __construct($message = null)
    {
        parent::__construct($message ?? $this->message, $this->code);
    }
}
