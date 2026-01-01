<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerTechnicianController;
use App\Http\Controllers\Api\TechnicianOwnedServiceController;
use App\Http\Controllers\Api\ServiceCategoryController; // Import new controller
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Public routes for authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public route for service categories
Route::get('/service-categories', [ServiceCategoryController::class, 'index']);

// Authenticated routes
Route::middleware('auth:web')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    // Technician Owned Service Management Routes
    Route::middleware(['can:isTechnician'])->prefix('technician')->group(function () {
        Route::get('owned-services', [TechnicianOwnedServiceController::class, 'index']);
        Route::post('owned-services', [TechnicianOwnedServiceController::class, 'store']);
        Route::get('owned-services/{owned_service}', [TechnicianOwnedServiceController::class, 'show']);
        Route::put('owned-services/{owned_service}', [TechnicianOwnedServiceController::class, 'update']);
        Route::delete('owned-services/{owned_service}', [TechnicianOwnedServiceController::class, 'destroy']);
    });

    // Customer View Technician Routes
    Route::prefix('customer')->group(function () {
        Route::get('/technicians', [CustomerTechnicianController::class, 'index']);
    });
});