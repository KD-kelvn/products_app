<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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

// LOGIN ROUTE
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// LOGOUT ROUTE
Route::middleware('auth:sanctum')->delete('/logout', [AuthenticatedSessionController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/products', [ProductController::class, 'index']);
Route::middleware('auth:sanctum')->get('/ratings', [RatingController::class, 'index']);
Route::middleware('auth:sanctum')->post('/ratings', [RatingController::class, 'store']);
Route::middleware('auth:sanctum')->put('/ratings/{id}', [RatingController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/ratings/{id}', [RatingController::class, 'destroy']);
