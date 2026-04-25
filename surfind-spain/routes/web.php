<?php

use App\Http\Controllers\Admin\BeachController as AdminBeachController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('playas', 'beaches.index')->name('beaches.index');
Route::view('mapa', 'map')->name('map');
Route::view('comunidad', 'community.index')->name('community.index');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::prefix('admin')->as('admin.')->middleware('role:admin')->group(function () {
        Route::group(['prefix' => 'playas', 'as' => 'beaches.', 'controller' => AdminBeachController::class], function () {
            Route::get('/', 'index')->name('index')->middleware('permission:view beaches');
            Route::get('/create', 'create')->name('create')->middleware('permission:create beaches');
            Route::post('/store', 'store')->name('store')->middleware('permission:create beaches');
            Route::get('/{beach}', 'show')->name('show')->middleware('permission:view beaches');
            Route::get('/{beach}/edit', 'edit')->name('edit')->middleware('permission:edit beaches');
            Route::put('/{beach}/edit', 'update')->name('update')->middleware('permission:edit beaches');
            Route::delete('/{beach}/destroy', 'destroy')->name('destroy')->middleware('permission:delete beaches');
        });

        Route::group(['prefix' => 'usuarios', 'as' => 'users.', 'controller' => AdminUserController::class], function () {
            Route::get('/', 'index')->name('index')->middleware('permission:manage users');
            Route::get('/create', 'create')->name('create')->middleware('permission:manage users');
            Route::post('/store', 'store')->name('store')->middleware('permission:manage users');
            Route::get('/{user}', 'show')->name('show')->middleware('permission:manage users');
            Route::get('/{user}/edit', 'edit')->name('edit')->middleware('permission:manage users');
            Route::put('/{user}/edit', 'update')->name('update')->middleware('permission:manage users');
            Route::delete('/{user}/destroy', 'destroy')->name('destroy')->middleware('permission:manage users');
        });
    });
});

require __DIR__.'/settings.php';
