<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConnectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderMobileController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\OrderPaymentController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Route Auth
Route::get('/login', [ConnectController::class, 'getLogin'])->name('login');
Route::post('/login', [ConnectController::class, 'postLogin']);
Route::get('/register', [ConnectController::class, 'getRegister'])->name('register');
Route::post('/register', [ConnectController::class, 'postRegister']);
Route::get('/logout', [ConnectController::class, 'getLogout'])->name('logout');

// Route Google
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth_google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Route Users Edit
Route::get('/account/edit', [UserController::class, 'getAccountEdit'])->name('account_edit');
// Route avatar
Route::post('/account/edit/avatar', [UserController::class, 'postAccountAvatar'])->name('account_avatar_edit');
Route::post('/account/edit/avatar/delete', [UserController::class, 'deleteAccountAvatar'])->name('account_avatar_delete');

// Route password
Route::post('/account/edit/password', [UserController::class, 'postAccountPassword'])->name('account_password_edit');
Route::post('/account/edit/info', [UserController::class, 'postAccountInfo'])->name('account_info_edit');

// Ordenes ***************
Route::prefix('orders')->name('order.')->group(function () {
    // Vista inicial / selección tipo (puede ser tu index ya existente)
    Route::get('select', [OrderController::class, 'select'])->name('select');
    // Crear orden por tipo (la vista que usas en los enlaces)
    Route::get('create-type/{type}', [OrderController::class, 'createType'])->name('create-type');
    // Vista de creación completa (si quieres ruta separada)
    Route::get('create', [OrderController::class, 'create'])->name('create');
    // Catálogo de ejemplo (view con categorías de ejemplo)
    Route::get('catalog', [OrderController::class, 'catalog'])->name('catalog');

    // Guardar orden (POST)
    Route::post('store', [OrderController::class, 'store'])->name('store');

    // view ticket
    Route::get('confirm/{id}', [OrderController::class, 'confirmation'])->name('confirm');

    // MOBILE ****

    // Vista inicial / selección tipo (puede ser tu index ya existente)
    Route::get('select-mobil', [OrderMobileController::class, 'selectMobile'])->name('select-mobile');
    // Crear orden por tipo (la vista que usas en los enlaces)
    Route::get('create-type-mobile/{type}', [OrderMobileController::class, 'createType'])->name('create-type-mobil');
    // Vista de creación completa (si quieres ruta separada)
    Route::get('create-mobile', [OrderMobileController::class, 'create'])->name('create-mobile');
    // Catálogo de ejemplo (view con categorías de ejemplo)
    Route::get('catalog-mobile', [OrderMobileController::class, 'catalog'])->name('catalog-mobile');

    // Guardar orden (POST)
    Route::post('store-mobile', [OrderMobileController::class, 'store'])->name('store-mobile');

    // view ticket
    Route::get('confirm-mobile/{id}', [OrderMobileController::class, 'confirmation'])->name('confirm-mobile');


});

