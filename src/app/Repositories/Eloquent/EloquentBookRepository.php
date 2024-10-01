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

    public function searchBooks(array $filters, $perPage = 20)
    {
        $query = Book::query();

        // Search by title
        if (!empty($filters['title'])) {
            $query->where('title', 'LIKE', '%' . $filters['title'] . '%');
        }

        // Search by author
        if (!empty($filters['author'])) {
            $query->where('author', 'LIKE', '%' . $filters['author'] . '%');
        }

        // Search by publisher
        if (!empty($filters['publisher'])) {
            $query->where('publisher', 'LIKE', '%' . $filters['publisher'] . '%');
        }

        // Search by client (related model)
        if (!empty($filters['client'])) {
            $query->whereHas('client', function ($q) use ($filters) {
                $q->where('first_name', 'LIKE', '%' . $filters['client'] . '%')
                  ->orWhere('last_name', 'LIKE', '%' . $filters['client'] . '%');
            });
        }

        // Return paginated results
        return $query->paginate($perPage);
    }


    public function findBookById($id)
    {
        return Book::with('client')->find($id);
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
