<?php

namespace App\Repositories\Eloquent;

use App\Exceptions\Core\Client\ClientNotFoundException;
use App\Exceptions\Core\Client\ClientHasRentedBooksException;
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
        $client = Client::with('rentedBooks')->find($id);

        if (!$client) {
            throw new ClientNotFoundException();
        }

        return $client;
    }

    public function createClient(array $data)
    {
        return Client::create($data);
    }

    public function deleteClient($id)
    {
        $client = Client::find($id);

        if (!$client) {
            throw new ClientNotFoundException();
        }

        if ($client->rentedBooks()->count() > 0) {
            throw new ClientHasRentedBooksException();
        }

        return $client->delete();
    }
}
