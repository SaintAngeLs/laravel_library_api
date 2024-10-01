<?php

namespace App\Repositories\Eloquent;

use App\Models\Book;
use App\Repositories\BookRepositoryInterface;

class EloquentBookRepository implements BookRepositoryInterface
{
    public function getAllBooksPaginated($perPage)
    {
        return Book::with('client')->paginate($perPage);
    }

    public function searchBooks($query)
    {
        return Book::where('title', 'LIKE', "%{$query}%")
                    ->orWhere('author', 'LIKE', "%{$query}%")
                    ->orWhereHas('client', function($q) use ($query) {
                        $q->where('first_name', 'LIKE', "%{$query}%")
                          ->orWhere('last_name', 'LIKE', "%{$query}%");
                    })->get();
    }

    public function findBookById($id)
    {
        return Book::with('client')->findOrFail($id);
    }

    public function rentBook($book, $clientId)
    {
        $book->is_rented = true;
        $book->rented_by = $clientId;
        return $book->save();
    }

    public function returnBook($book)
    {
        $book->is_rented = false;
        $book->rented_by = null;
        return $book->save();
    }
}
