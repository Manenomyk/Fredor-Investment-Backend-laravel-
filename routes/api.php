<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\itemlistcontroller;
use App\Http\Controllers\API\customerlistcontoller;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::post('authadditem', [itemlistcontroller::class, 'store']);
Route::post('createuser', [AuthController::class, 'store']);
Route::post('addcustomer', [customerlistcontoller::class, 'store']);



Route::get('adminViewUsers', [AuthController::class, 'index']);
Route::get('adminViewitems', [itemlistcontroller::class, 'index']);
Route::get('adminViewcustomerlist', [customerlistcontoller::class, 'index']);


Route::get('view_profile/{id}', [AuthController::class, 'edit']);
Route::put('updateprofile/{id}', [AuthController::class, 'update']);


Route::middleware(['auth:sanctum'])->group(function(){

    Route::post('logout', [AuthController::class, 'logout']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
