<?php
// MAILER
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\User\ProductsController;

    

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('home');
//     // return env('MY_NAME');
// });

// Route::get('users',[
//     UsersController::class,'index'      

// ]);

//login main screen
Route::get('admin/login', function () {
    return view('admin.login');
});

// dashboard
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::get('/admin/dashboard', [AdminsController::class, 'dashboard'])->name('admin.dashboard');

//login
Route::post('/admin/login', [AdminsController::class, 'loginPost'])->name('admin.loginPost');
Route::get('/admin/logout', [AdminsController::class, 'logout'])->name('admin.logout');

//layout main 
Route::get('layout/layout', function () {
    return view('layout.layout');
});



//products
Route::resource('products', ProductsController::class);

