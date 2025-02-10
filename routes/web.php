<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;


Route::get('/', [MainController::class, 'index'])->name('homePage');
Route::get('/register', [UserController::class, 'register'])->name('user.register');
Route::post('/register-post', [UserController::class, 'registerPost'])->name('user.register.post');
Route::get('/register/account-activate', [UserController::class, 'registerAccountActivate'])->name('user.register.accountActive');
Route::post('/register/account-activate', [UserController::class, 'registerAccountActivate'])->name('user.register.accountActive');
Route::get('/login', [UserController::class, 'login'])->name('user.login');
Route::post('/login-post', [UserController::class, 'loginPost'])->name('user.login.post');
Route::get('/logout', [UserController::class, 'logout'])->name('user.logout');





Route::prefix('shopping-bag',)->group(function (){
    Route::get('', [MainController::class, 'shoppingBag'])->name('shoppingBag');
    Route::post('addToCart', [MainController::class, 'addToCart'])->name('addToCart');
    Route::get('deleteToCart/(:num)', [MainController::class, 'deleteToCart'])->name('deleteToCart');
    Route::get('shoppingBagInc', [MainController::class, 'shoppingBagInc'])->name('shoppingBagInc');
    Route::get('shoppingBagDec', [MainController::class, 'shoppingBagDec'])->name('shoppingBagDec');
    Route::get('shoppingBagReset', [MainController::class, 'shoppingBagReset'])->name('shoppingBagReset');
});
Route::prefix('categories')->group(function (){
    Route::get('category-detail', [MainController::class, 'categoryDetail'])->name('categoryDetail');
    Route::get('sub-category-detail', [MainController::class, 'subCategoryDetail'])->name('subCategoryDetail');
});




Route::get('/public/assets/', [MainController::class, 'index'])->name('docs');
Route::get('/get-cities/{country_id}', [UserController::class, 'getCities']);
Route::get('/get-states/{city_id}', [UserController::class, 'getStates']);
