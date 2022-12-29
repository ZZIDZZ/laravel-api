<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->prefix('uom')->group(function(){
    Route::get('/', [UomController::class, 'index']);
    Route::post('/', [UomController::class, 'store']);
    // Route::put('//edit/{id}', [UomController::class, 'edit']);
    Route::put('/update/{id}', [UomController::class, 'update']);
    // Route::get('//add', [UomController::class, 'add']);
    Route::delete('/delete/{id}', [UomController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('product')->group(function(){
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/', [ProductController::class, 'store']);
    // Route::put('//edit/{id}', [ProductController::class, 'edit']);
    Route::put('/update/{id}', [ProductController::class, 'update']);
    // Route::get('//add', [ProductController::class, 'add']);
    Route::delete('/delete/{id}', [ProductController::class, 'delete']);
});