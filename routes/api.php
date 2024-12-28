<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ListingController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/check-email', [UserController::class, 'checkEmail']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/listings/search', [ListingController::class, 'search']);
Route::get('/listings/{listingId}', [ListingController::class, 'findById'])->where('listingId', '[1-9][0-9]*');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'getUser']);
        Route::patch('/', [UserController::class, 'update']);
        Route::post('/profile-image', [UserController::class, 'updateProfileImage']);
    });

    Route::prefix('listings')->group(function () {
        Route::post('/', [ListingController::class, 'create']);
        Route::put('/{listingId}', [ListingController::class, 'update']);
        Route::post('/{listingId}/image', [ListingController::class, 'updateImage']);
        Route::get('/owner', [ListingController::class, 'getByOwner']);
        Route::get('/owner/{listingId}', [ListingController::class, 'findByIdAndOwner']);
        Route::delete('/{listingId}', [ListingController::class, 'delete']);
    });
});
