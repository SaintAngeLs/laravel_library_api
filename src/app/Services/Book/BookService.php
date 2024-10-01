<?php

namespace App\Services\Book;

use App\Repositories\BookRepositoryInterface;
use App\Repositories\ClientRepositoryInterface;

class BookService
{
    protected $bookRepository;
    protected $clientRepository;

    const DEFAULT_PAGINATION = 20;

    public function __construct(BookRepositoryInterface $bookRepository, ClientRepositoryInterface $clientRepository)
    {
        $this->bookRepository = $bookRepository;
        $this->clientRepository = $clientRepository;
    }

    public function listBooksPaginated($perPage = null)
    {
        $perPage = $perPage ?? self::DEFAULT_PAGINATION;
        return $this->bookRepository->getAllBooksPaginated($perPage);
    }

    public function searchBooks(array $filters, $perPage = null)
    {
        $perPage = $perPage ?? self::DEFAULT_PAGINATION;
        return $this->bookRepository->searchBooks($filters, $perPage);
    }


    public function getBookDetails($id)
    {
        return $this->bookRepository->findBookById($id);
    }

    public function rentBook($bookId, $clientId)
    {
        $book = $this->bookRepository->findBookById($bookId);
        if ($book->is_rented) {
            throw new \Exception("Book is already rented.");
        }
        $client = $this->clientRepository->findClientById($clientId);
        return $this->bookRepository->rentBook($book, $client->id);
    }

    public function returnBook($bookId)
    {
        $book = $this->bookRepository->findBookById($bookId);
        if (!$book->is_rented) {
            throw new \Exception("Book is not rented.");
        }
        return $this->bookRepository->returnBook($book);
    }
}
