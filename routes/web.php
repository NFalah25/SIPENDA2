<?php

use App\Http\Controllers\ArsipPensiunController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/home', function () {
    return view('Page.dashboard');
})->name('home');
Route::get('/home2', function () {
    return view('Page.blank');
})->name('home2');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/arsip-pensiun-data', [DashboardController::class, 'getArsipPensiun'])->name('arsip.pensiun.data');
    Route::get('/arsip/download/{filename}', [ArsipPensiunController::class, 'download'])->name('arsip.download');
    Route::group(['prefix' => 'arsip-pensiun', 'middleware' => ['can:arsip']], function () {
        Route::get('/create', [ArsipPensiunController::class, 'create'])->name('arsip.create');
        Route::post('/store', [ArsipPensiunController::class, 'store'])->name('arsip.store');
        Route::get('/edit/{id}', [ArsipPensiunController::class, 'edit'])->name('arsip.edit');
        Route::put('/update/{id}', [ArsipPensiunController::class, 'update'])->name('arsip.update');
        Route::get('/view/{id}', [ArsipPensiunController::class, 'view'])->name('arsip.view');
        Route::delete('/destroy/{id}', [ArsipPensiunController::class, 'destroy'])->name('arsip.destroy');
    });
    Route::group(['prefix' => 'unit-kerja', 'middleware' => ['can:unit']], function () {
        Route::get('/', [UnitKerjaController::class, 'index'])->name('unit.index');
        Route::get('/create', [UnitKerjaController::class, 'create'])->name('unit.create');
        Route::post('/store', [UnitKerjaController::class, 'store'])->name('unit.store');
        Route::get('/edit/{id}', [UnitKerjaController::class, 'edit'])->name('unit.edit');
        Route::put('/update/{id}', [UnitKerjaController::class, 'update'])->name('unit.update');
        Route::delete('/destroy/{id}', [UnitKerjaController::class, 'destroy'])->name('unit.destroy');
        Route::get('/data', [UnitKerjaController::class, 'getUnitKerja'])->name('unit.data');
    });

    Route::group(['prefix' => 'user', 'middleware' => ['can:user']], function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::get('/data', [UserController::class, 'getUser'])->name('user.data');
    });

    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
});
