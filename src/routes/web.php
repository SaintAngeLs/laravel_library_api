<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Book\BookController;
use App\Http\Controllers\Client\ClientController;

Route::get('/', function () {
    return view('dashboard');
});

Route::prefix('v3')->group(function () {

    Route::get('books', [BookController::class, 'index']);
    Route::get('books/search', [BookController::class, 'search']);
    Route::get('books/{id}', [BookController::class, 'show']);
    Route::post('books/{bookId}/rent', [BookController::class, 'rentBook']);
    Route::post('books/{bookId}/return', [BookController::class, 'returnBook']);

    Route::get('clients', [ClientController::class, 'index']);
    Route::get('clients/{id}', [ClientController::class, 'show']);
    Route::post('clients', [ClientController::class, 'store']);
    Route::delete('clients/{id}', action: [ClientController::class, 'destroy']);
});
