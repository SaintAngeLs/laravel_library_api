<?php

namespace App\Dto;

use App\Models\Book;
use App\Dto\ClientDTO;

class BookDTO
{
    public int $id;
    public string $title;
    public string $author;
    public ?int $year_of_publication;
    public string $publisher;
    public bool $is_rented;
    public ?ClientDTO $client;

    public function __construct(Book $book)
    {
        $this->id = $book->id;
        $this->title = $book->title;
        $this->author = $book->author;
        $this->year_of_publication = $book->year_of_publication;
        $this->publisher = $book->publisher;
        $this->is_rented = $book->is_rented;
        $this->client = $book->is_rented ? $this->mapClient($book->client) : null;
    }

    /**
     * Maps client information to ClientDTO.
     *
     * @param \App\Models\Client|null $client
     * @return ClientDTO|null
     */
    private function mapClient(?\App\Models\Client $client): ?ClientDTO
    {
        if (!$client) {
            return null;
        }

        return new ClientDTO($client);
    }
}
