<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemsController;
use Illuminate\Support\Facades\Redirect;

require __DIR__.'/user.php';
require __DIR__.'/admin.php';

Route::get('/', function () {
    return Redirect::route('login');
});


Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('checkout', [CartController::class, 'checkout'])->name('checkout');


// Route::middleware(['auth'])->group(function () {
//     Route::get('/user/profile', [UserController::class, 'show'])->name('user.show');
//     Route::put('/user/update', [UserController::class, 'update'])->name('user.update');
// });


