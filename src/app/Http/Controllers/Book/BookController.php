<?php

namespace App\Http\Controllers\Book;

use App\Dto\BookDTO;
use App\Exceptions\Http\Book\BookNotFoundException;
use App\Exceptions\Http\Book\BookAlreadyRentedException;
use App\Http\Controllers\Controller;
use App\Services\Book\BookService;
use App\Http\Requests\Book\RentBookRequest;
use App\Http\Requests\Book\SearchBookRequest;
use App\Http\Requests\Book\ShowBookRequest;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * @OA\Get(
     *     path="/v3/books",
     *     summary="List books with pagination",
     *     description="Get a paginated list of books with their details.",
     *     operationId="getBooks",
     *     tags={"Books"},
     *     @OA\Response(
     *         response=200,
     *         description="List of books",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Book")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function index(): JsonResponse
    {
        $booksDTO = $this->bookService->listBooksPaginated();
        return response()->json($booksDTO->toArray());
    }

    /**
     * @OA\Get(
     *     path="/v3/books/search",
     *     summary="Search for books",
     *     description="Search books by title, author, or publisher.",
     *     operationId="searchBooks",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         required=false,
     *         description="Filter books by title",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="author",
     *         in="query",
     *         required=false,
     *         description="Filter books by author",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="publisher",
     *         in="query",
     *         required=false,
     *         description="Filter books by publisher",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="client",
     *         in="query",
     *         required=false,
     *         description="Filter books by client",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Search results",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Book")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function search(SearchBookRequest $request): JsonResponse
    {
        $filters = $request->only(['title', 'author', 'publisher', 'client']);
        $perPage = $request->get('perPage', 20);

        $books = $this->bookService->searchBooks($filters, $perPage);

        return response()->json([
            'data' => $books->items(),
            'pagination' => [
                'total' => $books->total(),
                'perPage' => $books->perPage(),
                'currentPage' => $books->currentPage(),
                'lastPage' => $books->lastPage(),
                'nextPageUrl' => $books->nextPageUrl(),
                'prevPageUrl' => $books->previousPageUrl(),
            ]
        ]);
    }

    /**
     * @OA\Get(
     *     path="/v3/books/{id}",
     *     summary="Get book details",
     *     description="Retrieve details of a specific book by its ID.",
     *     operationId="getBook",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the book",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book details",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     ),
     *     @OA\Response(response=404, description="Book not found"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function show(ShowBookRequest $request, $id): JsonResponse
    {
        try {
            $book = $this->bookService->getBookDetails($id);
            return response()->json($book);
        } catch (BookNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * @OA\Post(
     *     path="/v3/books/{bookId}/rent",
     *     summary="Rent a book",
     *     description="Rent a book to a client.",
     *     operationId="rentBook",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="bookId",
     *         in="path",
     *         required=true,
     *         description="ID of the book to rent",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="Client renting the book",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="client_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book rented successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Book rented successfully.")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Book not found"),
     *     @OA\Response(response=409, description="Book already rented"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function rentBook($bookId, RentBookRequest $request): JsonResponse
    {
        try {
            $this->bookService->rentBook($bookId, $request->client_id);
            return response()->json(['message' => 'Book rented successfully.']);
        } catch (BookAlreadyRentedException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        } catch (BookNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * @OA\Post(
     *     path="/v3/books/{bookId}/return",
     *     summary="Return a rented book",
     *     description="Return a book that was rented.",
     *     operationId="returnBook",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="bookId",
     *         in="path",
     *         required=true,
     *         description="ID of the book to return",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book returned successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Book returned successfully.")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Book not found"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function returnBook($bookId): JsonResponse
    {
        try {
            $this->bookService->returnBook($bookId);
            return response()->json(['message' => 'Book returned successfully.']);
        } catch (BookNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
}
