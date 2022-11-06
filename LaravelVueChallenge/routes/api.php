<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('products', [ProductController::class, 'index']);
Route::get('products/{id}', [ProductController::class, 'show']);
Route::post('add', [ProductController::class, 'store']);
Route::put('update/{id}', [ProductController::class, 'update']);
Route::delete('remove/{id}', [ProductController::class, 'destroy']);


Route::get('categories', [ProductController::class, 'categories']);
Route::get('filter', [ProductController::class, 'Filter']);
