<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\ClientService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index()
    {
        $clients = $this->clientService->listClients();
        return response()->json($clients);
    }

    public function show($id)
    {
        $client = $this->clientService->getClientDetails($id);
        return response()->json($client);
    }

    public function store(Request $request)
    {
        $data = $request->only(['first_name', 'last_name']);
        $client = $this->clientService->createClient($data);
        return response()->json($client);
    }

    public function destroy($id)
    {
        $this->clientService->deleteClient($id);
        return response()->json(['message' => 'Client deleted successfully.']);
    }
}
