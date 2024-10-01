<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Services\Book\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function index(Request $request)
    {
        $books = $this->bookService->listBooksPaginated();
        return response()->json($books);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $books = $this->bookService->searchBooks($query);
        return response()->json($books);
    }

    public function show($id)
    {
        $book = $this->bookService->getBookDetails($id);
        return response()->json($book);
    }

    public function rentBook($bookId, Request $request)
    {
        $clientId = $request->input('client_id');
        $this->bookService->rentBook($bookId, $clientId);
        return response()->json(['message' => 'Book rented successfully.']);
    }

    public function returnBook($bookId)
    {
        $this->bookService->returnBook($bookId);
        return response()->json(['message' => 'Book returned successfully.']);
    }
}
