<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\Book;
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

    public function show($id)
    {
        $book = $this->bookService->getBookDetails($id);

        if (!$book->is_rented) {
            $clients = Client::all();
            return view('pages.book.show', compact('book', 'clients'));
        }

        return view('pages.book.show', compact('book'));
    }

    public function rentBook($bookId, Request $request)
    {
        $clientId = $request->input('client_id');
        $this->bookService->rentBook($bookId, $clientId);
        return redirect()->route('pages.book.index')->with('success', 'Book rented successfully.');
    }

    public function returnBook($bookId)
    {
        $this->bookService->returnBook($bookId);
        return redirect()->route('pages.book.index')->with('success', 'Book returned successfully.');
    }
}
