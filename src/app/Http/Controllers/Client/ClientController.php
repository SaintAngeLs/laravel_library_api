<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\ClientService;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\DeleteClientRequest;
use App\Exceptions\Http\Client\ClientNotFoundException;
use App\Exceptions\Http\Client\ClientHasRentedBooksException;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    /**
     * @OA\Get(
     *     path="/v3/clients",
     *     summary="Get a list of clients",
     *     tags={"Clients"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of clients",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Client")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $clients = $this->clientService->listClients();
        return response()->json($clients, 200);
    }

    /**
     * @OA\Get(
     *     path="/v3/clients/{id}",
     *     summary="Show details of a specific client",
     *     tags={"Clients"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the client",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Details of the client",
     *         @OA\JsonContent(ref="#/components/schemas/Client")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client not found"
     *     )
     * )
     */
    public function show($id): JsonResponse
    {
        try {
            $client = $this->clientService->getClientDetails($id);
            return response()->json($client, 200);
        } catch (ClientNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * @OA\Post(
     *     path="/v3/clients",
     *     summary="Create a new client",
     *     tags={"Clients"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="first_name", type="string", description="First name of the client"),
     *             @OA\Property(property="last_name", type="string", description="Last name of the client")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Client created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Client")
     *     )
     * )
     */
    public function store(StoreClientRequest $request): JsonResponse
    {
        $data = $request->validated();
        $client = $this->clientService->createClient($data);
        return response()->json($client, 201); // Created
    }

    /**
     * @OA\Delete(
     *     path="/v3/clients/{id}",
     *     summary="Delete a client",
     *     tags={"Clients"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the client to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Client deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client not found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Client has rented books"
     *     )
     * )
     */
    public function destroy($id, DeleteClientRequest $request): JsonResponse
    {
        try {
            $this->clientService->deleteClient($id);
            return response()->json(['message' => 'Client deleted successfully.'], 200);
        } catch (ClientNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        } catch (ClientHasRentedBooksException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }

}
