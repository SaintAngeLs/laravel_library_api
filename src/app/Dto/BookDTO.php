<?php

namespace App\DTO;

class BookDTO
{
    public $id;
    public $title;
    public $author;
    public $year_of_publication;
    public $publisher;
    public $is_rented;
    public $client;

    public function __construct($book)
    {
        $this->id = $book->id;
        $this->title = $book->title;
        $this->author = $book->author;
        $this->year_of_publication = $book->year_of_publication;
        $this->publisher = $book->publisher;
        $this->is_rented = $book->is_rented;
        $this->client = $book->is_rented ? $this->mapClient($book->client) : null;
    }

    private function mapClient($client)
    {
        return [
            'id' => $client->id,
            'first_name' => $client->first_name,
            'last_name' => $client->last_name,
        ];
    }
}
