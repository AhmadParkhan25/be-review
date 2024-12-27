<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CastController;
use App\Http\Controllers\API\CastMovieController;
use App\Http\Controllers\API\GenreController;
use App\Http\Controllers\API\MovieController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\RoleController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('v1')->group(function () {
    Route::apiResource('cast', CastController::class);
    Route::apiResource('genre', GenreController::class);
    Route::apiResource('movie', MovieController::class);
    Route::apiResource('role', RoleController::class)->middleware(['auth:api', 'isadmin']);
    Route::apiResource('cast-movie', CastMovieController::class);
    Route::post('review', [ReviewController::class, 'updateOrCreate'])->middleware(['verified', 'auth:api']);

    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
        Route::post('generate-otp-code', [AuthController::class, 'generateOtpCode'])->middleware('auth:api');
        Route::post('verifikasi-akun', [AuthController::class, 'verifikasiAkun'])->middleware('auth:api');
    })->middleware('api');
    Route::get('me', [AuthController::class, 'currentUser'])->middleware('auth:api');

    Route::post('profile', [ProfileController::class, 'updateOrCreate'])->middleware(['auth:api', 'verified']);
});
