<?php

namespace App\Http\Controllers\Client;

use App\Exceptions\Http\Client\ClientNotFoundException;
use App\Exceptions\Http\Client\ClientHasRentedBooksException;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Client;
use App\Services\Client\ClientService;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\DeleteClientRequest;

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
            $client = Client::findOrFail($id);
            $rentedBooks = Book::where('rented_by', $client->id)->get();

            return view('pages.client.show', compact('client', 'rentedBooks'));
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
     * @param StoreClientRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreClientRequest $request)
    {
        try {
            $data = $request->validated();  
            $this->clientService->createClient($data);
            return redirect()->route('pages.client.index')->with('success', 'Client created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'There was an issue creating the client: ' . $e->getMessage());
        }
    }


    /**
     * Delete a client by ID.
     *
     * @param DeleteClientRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DeleteClientRequest $request, $id)
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
