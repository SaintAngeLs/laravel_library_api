<?php

namespace App\Services\Client;

use App\Repositories\ClientRepositoryInterface;

class ClientService
{
    protected $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function listClients()
    {
        return $this->clientRepository->getAllClients();
    }

    public function getClientDetails($id)
    {
        return $this->clientRepository->findClientById($id);
    }

    public function createClient($data)
    {
        return $this->clientRepository->createClient($data);
    }

    public function deleteClient($id)
    {
        return $this->clientRepository->deleteClient($id);
    }
}
