<?php

use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use App\Http\Controllers\APIProductController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//login and register


Route::get('login', [APIController::class, 'getUser']);
Route::post('login', [APIController::class, 'login']);
Route::post('register', [APIController::class, 'register']);

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('accounts', [APIController::class, 'accounts']);
    Route::post('logout', [APIController::class, 'logout']);
});

//products
Route::get('getProduct',[APIProductController::class, 'get']);
Route::post('add-product',[APIProductController::class, 'add']);
Route::put('edit-product',[APIProductController::class, 'edit']);
Route::delete('delete-product',[APIProductController::class, 'delete']);