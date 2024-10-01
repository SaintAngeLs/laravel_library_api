<?php

namespace App\Services\Book;

use App\Dto\BookDTO;
use App\Exceptions\Core\Book\BookAlreadyRentedException;
use App\Exceptions\Core\Book\BookNotRentedException;
use App\Exceptions\Http\Book\BookNotFoundException;
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
        $books = $this->bookRepository->getAllBooksPaginated($perPage);

        return $books->map(function ($book) {
            return new BookDTO($book);
        });
    }

    public function searchBooks(array $filters, $perPage = null)
    {
        $perPage = $perPage ?? self::DEFAULT_PAGINATION;
        $books = $this->bookRepository->searchBooks($filters, $perPage);

        return $books->map(function ($book) {
            return new BookDTO($book);
        });
    }

    public function getBookDetails($id)
    {
        $book = $this->bookRepository->findBookById($id);

        if (!$book) {
            throw new BookNotFoundException();
        }

        return new BookDTO($book);
    }

    public function rentBook($bookId, $clientId)
    {
        $book = $this->bookRepository->findBookById($bookId);

        if (!$book) {
            throw new BookNotFoundException();
        }

        if ($book->is_rented) {
            throw new BookAlreadyRentedException();
        }

        return $this->bookRepository->rentBook($book, $clientId);
    }

    public function returnBook($bookId)
    {
        $book = $this->bookRepository->findBookById($bookId);

        if (!$book) {
            throw new BookNotFoundException();
        }

        return $this->bookRepository->returnBook($book);
    }
}
