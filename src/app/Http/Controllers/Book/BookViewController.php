<?php

namespace App\Http\Controllers\Book;

use App\Exceptions\Http\Book\BookNotFoundException;
use App\Exceptions\Http\BookAlreadyRentedException;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Services\Book\BookService;
use Illuminate\Http\Request;

class BookViewController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Display the book listing page with filters.
     */
    public function index(Request $request)
    {
        $filters = [
            'title' => $request->input('title'),
            'author' => $request->input('author'),
            'publisher' => $request->input('publisher'),
        ];

        $perPage = 20;
        $books = $this->bookService->searchBooks($filters, $perPage);

        return view('pages.book.index', compact('books', 'filters'));
    }

    /**
     * Search for books using filters and return JSON response.
     */
    public function search(Request $request)
    {
        $filters = [
            'title' => $request->input('title'),
            'author' => $request->input('author'),
            'publisher' => $request->input('publisher'),
        ];

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
     * Show details of a specific book and handle the case where the book may not exist.
     */
    public function show($id)
    {
        try {
            $book = $this->bookService->getBookDetails($id);

            if (!$book->is_rented) {
                $clients = Client::all();
                return view('pages.book.show', compact('book', 'clients'));
            }

            return view('pages.book.show', compact('book'));

        } catch (BookNotFoundException $e) {
            return redirect()->route('pages.book.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Rent a book to a client and handle errors related to book availability.
     */
    public function rentBook($bookId, Request $request)
    {
        $clientId = $request->input('client_id');

        try {
            $this->bookService->rentBook($bookId, $clientId);
            return redirect()->route('pages.book.index')->with('success', 'Book rented successfully.');
        } catch (BookAlreadyRentedException $e) {
            return redirect()->route('pages.book.index')->with('error', $e->getMessage());
        } catch (BookNotFoundException $e) {
            return redirect()->route('pages.book.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Return a rented book and handle errors such as book not found.
     */
    public function returnBook($bookId)
    {
        try {
            $this->bookService->returnBook($bookId);
            return redirect()->route('pages.book.index')->with('success', 'Book returned successfully.');
        } catch (BookNotFoundException $e) {
            return redirect()->route('pages.book.index')->with('error', $e->getMessage());
        }
    }
}
