<?php

use App\Http\Controllers\{
    CategoryController,
    DashboardController,
    SatuanController,
    SemesterController,
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::group([
    'middleware' => ['auth', 'role:admin,user']
], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::group([
        'middleware' => 'role:admin'
    ], function () {
        // route semester
        Route::get('/semester/data', [SemesterController::class, 'data'])->name('semester.data');
        Route::resource('/semester', SemesterController::class)->except('create', 'edit');
        Route::put('/semester/{id}/update-status', [SemesterController::class, 'updateStatus'])->name('semester.update_status');

        // route satuan / units
        Route::get('/satuan/data', [SatuanController::class, 'data'])->name('satuan.data');
        Route::resource('/satuan', SatuanController::class)->except('create', 'edit');

        // route kategori
        Route::get('/jenis-barang/data', [CategoryController::class, 'data'])->name('jenis-barang.data');
        Route::resource('/jenis-barang', CategoryController::class)->except('create', 'edit');
    });
});
