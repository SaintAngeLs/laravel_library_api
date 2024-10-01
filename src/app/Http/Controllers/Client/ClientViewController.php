<?php

namespace App\Http\Controllers\Client;

use App\Exceptions\Http\Client\ClientNotFoundException;
use App\Exceptions\Http\Client\ClientHasRentedBooksException;
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

    /**
     * Display a listing of clients.
     */
    public function index()
    {
        $clients = $this->clientService->listClients();
        return view('pages.client.index', compact('clients'));
    }

    /**
     * Show a specific client by ID.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show($id)
    {
        try {
            $client = $this->clientService->getClientDetails($id);
            return view('pages.client.show', compact('client'));
        } catch (ClientNotFoundException $e) {
            return redirect()->route('pages.client.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form to create a new client.
     */
    public function create()
    {
        return view('pages.client.create');
    }

    /**
     * Store a new client in the system.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->only(['first_name', 'last_name']);
        $this->clientService->createClient($data);
        return redirect()->route('pages.client.index')->with('success', 'Client created successfully.');
    }

    /**
     * Delete a client by ID.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $this->clientService->deleteClient($id);
            return redirect()->route('pages.client.index')->with('success', 'Client deleted successfully.');
        } catch (ClientNotFoundException $e) {
            return redirect()->route('pages.client.index')->with('error', $e->getMessage());
        } catch (ClientHasRentedBooksException $e) {
            return redirect()->route('pages.client.index')->with('error', $e->getMessage());
        }
    }
}
