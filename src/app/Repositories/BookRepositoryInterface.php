<?php

namespace App\Repositories;

interface BookRepositoryInterface
{
    public function getAllBooksPaginated($perPage);
    public function searchBooks(array $filters, $perPage = 20);
    public function findBookById($id);
    public function rentBook($book, $clientId);
    public function returnBook($book);
}
