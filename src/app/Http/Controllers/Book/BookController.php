<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Services\Book\BookService;
use Illuminate\Http\Request;

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
     *     summary="Get a list of books",
     *     tags={"Books"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of books",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Book")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $books = $this->bookService->listBooksPaginated();
        return response()->json($books);
    }

    /**
     * @OA\Get(
     *     path="/v3/books/search",
     *     summary="Search books with filters",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="Search by title",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="author",
     *         in="query",
     *         description="Search by author",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="publisher",
     *         in="query",
     *         description="Search by publisher",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Filtered list of books",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Book")
     *             ),
     *             @OA\Property(
     *                 property="pagination",
     *                 type="object",
     *                 @OA\Property(property="total", type="integer"),
     *                 @OA\Property(property="perPage", type="integer"),
     *                 @OA\Property(property="currentPage", type="integer"),
     *                 @OA\Property(property="lastPage", type="integer"),
     *                 @OA\Property(property="nextPageUrl", type="string"),
     *                 @OA\Property(property="prevPageUrl", type="string")
     *             )
     *         )
     *     )
     * )
     */
    public function search(Request $request)
    {
        $filters = [
            'title' => $request->input('title'),
            'author' => $request->input('author'),
            'publisher' => $request->input('publisher'),
        ];

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
     *     summary="Get details of a specific book",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the book to retrieve",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Details of the book",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     )
     * )
     */
    public function show($id)
    {
        $book = $this->bookService->getBookDetails($id);
        return response()->json($book);
    }

    /**
     * @OA\Post(
     *     path="/v3/books/{bookId}/rent",
     *     summary="Rent a book",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="bookId",
     *         in="path",
     *         description="ID of the book to rent",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="client_id", type="integer", description="ID of the client renting the book")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book rented successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Book cannot be rented"
     *     )
     * )
     */
    public function rentBook($bookId, Request $request)
    {
        $clientId = $request->input('client_id');
        $this->bookService->rentBook($bookId, $clientId);
        return response()->json(['message' => 'Book rented successfully.']);
    }

    /**
     * @OA\Post(
     *     path="/v3/books/{bookId}/return",
     *     summary="Return a rented book",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="bookId",
     *         in="path",
     *         description="ID of the book to return",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book returned successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Book cannot be returned"
     *     )
     * )
     */
    public function returnBook($bookId)
    {
        $this->bookService->returnBook($bookId);
        return response()->json(['message' => 'Book returned successfully.']);
    }
}
