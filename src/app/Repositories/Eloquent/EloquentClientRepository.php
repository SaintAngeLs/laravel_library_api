<?php

namespace App\Repositories\Eloquent;

use App\Models\Client;
use App\Repositories\ClientRepositoryInterface;

class EloquentClientRepository implements ClientRepositoryInterface
{
    public function getAllClients()
    {
        return Client::all();
    }

    public function findClientById($id)
    {
        return Client::with('rentedBooks')->findOrFail($id);
    }

    public function createClient(array $data)
    {
        return Client::create($data);
    }

    public function deleteClient($id)
    {
        $client = Client::findOrFail($id);
        if ($client->rentedBooks()->count() > 0) {
            throw new \Exception("Client cannot be deleted as they have rented books.");
        }
        return $client->delete();
    }
}
