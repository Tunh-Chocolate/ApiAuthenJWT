<?php
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductsController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::post('/change-pass', [AuthController::class, 'changePassWord']);    
});

//product
Route::middleware('auth:api')->group(function () {
    Route::get('/products', 'App\Http\Controllers\API\ProductsController@index');
    Route::get('/products/{id}', 'App\Http\Controllers\API\ProductsController@show');
    Route::post('/products/store', 'App\Http\Controllers\API\ProductsController@store');
    Route::post('/products/update/{id}', 'App\Http\Controllers\API\ProductsController@update');
    Route::delete('/products/delete/{id}', 'App\Http\Controllers\API\ProductsController@destroy');
});

