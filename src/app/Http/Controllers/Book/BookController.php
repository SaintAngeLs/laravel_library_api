<?php

namespace App\Http\Controllers\Book;

use App\DTO\BookDTO;
use App\Exceptions\Http\Book\BookNotFoundException;
use App\Exceptions\Http\BookAlreadyRentedException;
use App\Http\Controllers\Controller;
use App\Services\Book\BookService;
use App\Http\Requests\Book\RentBookRequest;
use App\Http\Requests\Book\SearchBookRequest;
use App\Http\Requests\Book\ShowBookRequest;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * List books with pagination.
     */
    public function index(): JsonResponse
    {
        $books = $this->bookService->listBooksPaginated();
        return response()->json($books);
    }

    /**
     * Search books using filters.
     */
    public function search(SearchBookRequest $request): JsonResponse
    {
        // Request validation has already occurred in SearchBookRequest
        $filters = $request->only(['title', 'author', 'publisher']);
        $perPage = $request->get('perPage', 20);

        $books = $this->bookService->searchBooks($filters, $perPage);

        return response()->json([
            'data' => $books->items(),
            'pagination' => [
                'total' => $books->total(),
                'perPage' => $books->perPage(),
                'currentPage' => $books->currentPage(),
                'lastPage' => $books->lastPage(),
                'nextPageUrl' => $books->nextPageUrl(),
                'prevPageUrl' => $books->previousPageUrl(),
            ]
        ]);
    }

    /**
     * Show details of a specific book.
     */
    public function show(ShowBookRequest $request, $id): JsonResponse
    {
        try {
            $book = $this->bookService->getBookDetails($id);
            return response()->json($book);
        } catch (BookNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Rent a book to a client.
     */
    public function rentBook($bookId, RentBookRequest $request): JsonResponse
    {
        try {
            $this->bookService->rentBook($bookId, $request->client_id);
            return response()->json(['message' => 'Book rented successfully.']);
        } catch (BookAlreadyRentedException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        } catch (BookNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Return a rented book.
     */
    public function returnBook($bookId): JsonResponse
    {
        try {
            $this->bookService->returnBook($bookId);
            return response()->json(['message' => 'Book returned successfully.']);
        } catch (BookNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
}
