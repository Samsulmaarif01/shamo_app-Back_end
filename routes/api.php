<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIUserController;
use App\Http\Controllers\APIProductController;
use App\Http\Controllers\APIProductCategoriesController;
use App\Http\Controllers\APITransactionController;
use Illuminate\Validation\ValidationException;

// Route to fetch current user data
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route for product listing (APIProductController)
Route::resource('products', APIProductController::class);

// Route for product category listing (APIProductCategoriesController)
Route::resource('categories', APIProductCategoriesController::class);

// Routes for user registration and login (POST method)
Route::post('register', [APIUserController::class, 'register']);
Route::post('login', [APIUserController::class, 'login']);

// Authenticated routes group
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [APIUserController::class, 'fetch']);
    Route::post('user/profile', [APIUserController::class, 'updateProfile']);
    Route::post('logout', [APIUserController::class, 'logout']);

    Route::get('transactions', [APITransactionController::class, 'all']);
    Route::post('checkout', [APITransactionController::class, 'checkout']);
});