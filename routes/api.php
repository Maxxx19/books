<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BooksController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'middleware' => 'api',
], function ($router) {
Route::get('/createBook/{book}/{author}/{publishingHouse}', [\App\Http\Controllers\Api\BooksController::class, 'createBook'])->name('createBook');
Route::get('/getBooks', [\App\Http\Controllers\Api\BooksController::class, 'getBooks'])->name('getBooks');
Route::get('/editBook/{book}/{author}/{publishingHouse}', [\App\Http\Controllers\Api\BooksController::class, 'editBook'])->name('editBook');
Route::get('/deleteBook/{book}', [\App\Http\Controllers\Api\BooksController::class, 'deleteBook'])->name('deleteBook');
});