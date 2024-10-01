<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\ClientService;
use Illuminate\Http\Request;

class ClientViewController extends Controller
{
    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index()
    {
        $clients = $this->clientService->listClients();
        return view('pages.client.index', compact('clients'));
    }

    public function show($id)
    {
        $client = $this->clientService->getClientDetails($id);
        return view('pages.client.show', compact('client'));
    }

    public function create()
    {
        return view('pages.client.create');
    }

    public function store(Request $request)
    {
        $data = $request->only(['first_name', 'last_name']);
        $this->clientService->createClient($data);
        return redirect()->route('pages.client.index')->with('success', 'Client created successfully.');
    }

    public function destroy($id)
    {
        $this->clientService->deleteClient($id);
        return redirect()->route('pages.client.index')->with('success', 'Client deleted successfully.');
    }
}
