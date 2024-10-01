<?php

namespace App\Repositories;

interface ClientRepositoryInterface
{
    public function getAllClients();
    public function findClientById($id);
    public function createClient(array $data);
    public function deleteClient($id);
}
