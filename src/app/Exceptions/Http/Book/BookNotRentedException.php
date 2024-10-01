<?php

namespace App\Exceptions\Http\Book;

use Exception;

/**
 * @OA\Schema(
 *     schema="BookNotRentedException",
 *     title="BookNotRentedException",
 *     description="Exception thrown when attempting to return a book that is not currently rented",
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
class BookNotRentedException extends Exception
{
    protected $message = 'This book is not currently rented.';
    protected $code = 409; // Conflict

    public function __construct($message = null)
    {
        parent::__construct($message ?? $this->message, $this->code);
    }
}
