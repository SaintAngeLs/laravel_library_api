<?php

namespace App\Repositories;

interface BookRepositoryInterface
{
    public function getAllBooksPaginated($perPage);
    public function searchBooks($query);
    public function findBookById($id);
    public function rentBook($book, $clientId);
    public function returnBook($book);
}
