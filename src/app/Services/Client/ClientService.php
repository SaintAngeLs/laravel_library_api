<?php

namespace App\Services\Client;

use App\Dto\ClientDTO;
use App\Exceptions\Core\Client\ClientHasRentedBooksException as CoreClientHasRentedBooksException;
use App\Exceptions\Core\Client\ClientNotFoundException as CoreClientNotFoundException;
use App\Exceptions\Http\Client\ClientNotFoundException;
use App\Exceptions\Http\Client\ClientHasRentedBooksException;
use App\Repositories\ClientRepositoryInterface;
use App\Services\Book\BookService;

class ClientService
{
    protected $clientRepository;
    protected $bookService;

    public function __construct(ClientRepositoryInterface $clientRepository, BookService $bookService)
    {
        $this->clientRepository = $clientRepository;
        $this->bookService = $bookService;
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
        try {
            $client = $this->clientRepository->findClientById($id);
            return new ClientDTO($client);
        } catch (CoreClientNotFoundException $e) {
            throw new ClientNotFoundException($e->getMessage());
        }
    }

    public function createClient($data): ClientDTO
    {
        $client = $this->clientRepository->createClient($data);
        return new ClientDTO($client);
    }

    public function deleteClient($id)
    {
        try {
            $client = $this->clientRepository->findClientById($id);

            if (!$client) {
                throw new ClientNotFoundException();
            }

            if ($client->rentedBooks->count() > 0) {
                throw new ClientHasRentedBooksException();
            }

            return $this->clientRepository->deleteClient($id);
        } catch (CoreClientNotFoundException $e) {
            throw new ClientNotFoundException($e->getMessage());
        } catch (CoreClientHasRentedBooksException $e) {
            throw new ClientHasRentedBooksException($e->getMessage());
        }
    }
}
