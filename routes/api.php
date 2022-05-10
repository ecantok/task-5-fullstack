<?php

use App\Http\Controllers\api\v1\PassportAuthController;
use App\Http\Controllers\api\v1\PostControllerApi;
use App\Http\Controllers\TestingController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('v1/login', [PassportAuthController::class, 'login']);
Route::post('v1/register', [PassportAuthController::class, 'register']);

Route::prefix('v1')->middleware('auth:api')->group(function() {
    // User Info
    Route::post('userinfo', [PassportAuthController::class, 'user_info']);

    // Restful api posts
    Route::apiResource('posts', PostControllerApi::class);
    // Route::get('posts', [PostController::class, 'index']);
    // Route::post('posts/create', [PostControllerApi::class, 'store']);
    // Route::get('posts/{id}', [PostController::class, 'show']);
    // Route::match(['PUT', 'PATCH'], 'posts/{id}', [PostController::class, 'update']);
    // Route::delete('posts/{id}', [PostController::class, 'destroy']);
    // Route::resource('test', TestingController::class);
});
