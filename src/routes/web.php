<?php


/**
 * @OA\Info(
 *     title="Library API Documentation",
 *     version="1.0.0",
 *     description="This is the API documentation for the Library system.",
 *     @OA\Contact(
 *         email="support@libraryapi.com"
 *     )
 * )
 */

/**
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Library API server"
 * )
 */


use App\Http\Controllers\Book\BookViewController;
use App\Http\Controllers\Client\ClientViewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Book\BookController;
use App\Http\Controllers\Client\ClientController;


Route::get('/', function () {
    return view('dashboard');
});

Route::prefix('v3')->group(function () {

    Route::prefix('books')->group(function () {
        Route::get('/', [BookController::class, 'index']);
        Route::get('/search', [BookController::class, 'search']);
        Route::get('/{id}', [BookController::class, 'show']);
        Route::post('/{bookId}/rent', [BookController::class, 'rentBook']);
        Route::post('/{bookId}/return', [BookController::class, 'returnBook']);
    });

    Route::prefix('clients')->group(function () {
        Route::get('/', [ClientController::class, 'index']);
        Route::get('/{id}', [ClientController::class, 'show']);
        Route::post('/', [ClientController::class, 'store']);
        Route::delete('/{id}', [ClientController::class, 'destroy']);
    });
});


Route::prefix('pages')->group(function () {
    Route::prefix('books')->group(function () {
        Route::get('/', [BookViewController::class, 'index'])->name('pages.book.index');
        Route::get('/{id}', [BookViewController::class, 'show'])->name('pages.book.show');
        Route::get('/search', [BookViewController::class, 'search'])->name('pages.book.search');
        Route::post('/{bookId}/rent', [BookViewController::class, 'rentBook'])->name('pages.book.rent');
        Route::post('/{bookId}/return', [BookViewController::class, 'returnBook'])->name('pages.book.return');
    });

    Route::prefix('clients')->group(function () {
        Route::get('/', [ClientViewController::class, 'index'])->name('pages.client.index');
        Route::get('/create', [ClientViewController::class, 'create'])->name('pages.client.create');
        Route::post('/', [ClientViewController::class, 'store'])->name('pages.client.store');
        Route::get('/{id}', [ClientViewController::class, 'show'])->name('pages.client.show');
        Route::delete('/{id}', [ClientViewController::class, 'destroy'])->name('pages.client.destroy');
    });
});
