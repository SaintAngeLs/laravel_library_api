<?php

namespace App\Services\Client;

use App\Dto\ClientDTO;
use App\Exceptions\Core\Client\ClientNotFoundException;
use App\Exceptions\Core\Client\ClientHasRentedBooksException;
use App\Repositories\ClientRepositoryInterface;

class ClientService
{
    protected $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function listClients(): mixed
    {
        $clients = $this->clientRepository->getAllClients();
        return $clients->map(function ($client) {
            return new ClientDTO($client);
        });
    }

    public function getClientDetails($id): ClientDTO
    {
        $client = $this->clientRepository->findClientById($id);

        if (!$client) {
            throw new ClientNotFoundException();
        }

        return new ClientDTO($client);
    }

    public function createClient($data): ClientDTO
    {
        $client = $this->clientRepository->createClient($data);
        return new ClientDTO($client);
    }

    public function deleteClient($id)
    {
        $client = $this->clientRepository->findClientById($id);

        if (!$client) {
            throw new ClientNotFoundException();
        }

        if ($client->rentedBooks()->count() > 0) {
            throw new ClientHasRentedBooksException();
        }

        return $this->clientRepository->deleteClient($id);
    }
}
