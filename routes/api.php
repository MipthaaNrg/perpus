<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BukuControllers;
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

Route::get('/books', [App\Http\Controllers\API\BukuControllers::class, 'getBuku']);

Route::post('/penerbit', [App\Http\Controllers\API\PenerbitControllers::class, 'store']);

Route::get('/books/{code}', [App\Http\Controllers\API\BukuControllers::class, 'getBukuCode']);

Route::post('/addBooks', [App\Http\Controllers\API\BukuControllers::class, 'store']);

Route::post('/updateBooks', [App\Http\Controllers\API\BukuControllers::class, 'ubah']);

Route::post('/deleteBooks',[App\Http\Controllers\API\BukuControllers::class, 'delete']);
