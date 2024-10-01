<?php

namespace App\Dto;

class ClientDTO
{
    public $id;
    public $first_name;
    public $last_name;
    public $rentedBooks;

    public function __construct($client)
    {
        $this->id = $client->id;
        $this->first_name = $client->first_name;
        $this->last_name = $client->last_name;
        $this->rentedBooks = $this->mapRentedBooks($client->rentedBooks);
    }

    private function mapRentedBooks($rentedBooks)
    {
        return $rentedBooks->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
            ];
        })->toArray();
    }
}
