<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\API\UserProductoController;
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

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);

Route::middleware('auth:api')->get('/user', function (Request $request){
    return $request->user();
});


Route::middleware('auth:api')->group(function () {
    Route::apiResource('productos',ProductoController::class);
    Route::apiResource('userproductos', UserProductoController::class);

});