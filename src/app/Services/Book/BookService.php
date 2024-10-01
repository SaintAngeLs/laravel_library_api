<?php

namespace App\Services\Book;

use App\Dto\BookDTO;
use App\Exceptions\Core\Book\BookAlreadyRentedException;
use App\Exceptions\Http\Book\BookNotFoundException;
use App\Repositories\BookRepositoryInterface;
use App\Repositories\ClientRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

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

    /**
     * List paginated books, returning a collection of BookDTOs.
     */
    public function listBooksPaginated($perPage = null): Collection
    {
        $perPage = $perPage ?? self::DEFAULT_PAGINATION;
        $books = $this->bookRepository->getAllBooksPaginated($perPage);

        return $books->map(function ($book) {
            return new BookDTO($book);
        });
    }

    /**
     * Search books using filters and return a collection of BookDTOs.
     */
    public function searchBooks(array $filters, $perPage = null): LengthAwarePaginator
    {
        $perPage = $perPage ?? self::DEFAULT_PAGINATION;
        $paginatedBooks = $this->bookRepository->searchBooks($filters, $perPage);

        $mappedBooks = $paginatedBooks->getCollection()->map(function ($book) {
            return new BookDTO($book);
        });

        return new LengthAwarePaginator(
            $mappedBooks,
            $paginatedBooks->total(),
            $paginatedBooks->perPage(),
            $paginatedBooks->currentPage(),
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }

    /**
     * Get details of a single book by its ID.
     */
    public function getBookDetails($id): BookDTO
    {
        $book = $this->bookRepository->findBookById($id);

        if (!$book) {
            throw new BookNotFoundException();
        }

        $book->load('client');

        return new BookDTO($book);
    }

    /**
     * Rent a book to a client.
     */
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

    /**
     * Return a rented book.
     */
    public function returnBook($bookId)
    {
        $book = $this->bookRepository->findBookById($bookId);

        if (!$book) {
            throw new BookNotFoundException();
        }

        return $this->bookRepository->returnBook($book);
    }
}
