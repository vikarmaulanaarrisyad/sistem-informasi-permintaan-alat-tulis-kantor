<?php

use App\Http\Controllers\{
    CategoryController,
    DashboardController,
    PengeluaranBarang,
    PermintaanBarang,
    ProductController,
    SatuanController,
    SemesterController,
    SupplierController,
    VerifikasiPermintaanController,
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

        // route supplier
        Route::get('/supplier/data', [SupplierController::class, 'data'])->name('supplier.data');
        Route::resource('/supplier', SupplierController::class)->except('create', 'edit');

        // route satuan / units
        Route::get('/satuan/data', [SatuanController::class, 'data'])->name('satuan.data');
        Route::resource('/satuan', SatuanController::class)->except('create', 'edit');

        // route kategori
        Route::get('/jenis-barang/data', [CategoryController::class, 'data'])->name('jenis-barang.data');
        Route::resource('/jenis-barang', CategoryController::class)->except('create', 'edit');

        // route barang
        Route::get('/barang/data', [ProductController::class, 'data'])->name('barang.data');
        Route::resource('/barang', ProductController::class);
        Route::get('/barang/{id}/detail', [ProductController::class, 'detail'])->name('barang.detail');

        // route verifikasi permintaan
        Route::get('/verifikasi-permintaan/data', [VerifikasiPermintaanController::class, 'data'])->name('verifikasi-permintaan.data');
        Route::get('/verifikasi-permintaan', [VerifikasiPermintaanController::class, 'index'])->name('verifikasi-permintaan.index');
        Route::post('/verifikasi-permintaan/approval', [VerifikasiPermintaanController::class, 'approval'])->name('verifikasi-permintaan.approval');

        // route pengeluaran barang
        Route::get('/pengeluaran-barang/data', [PengeluaranBarang::class, 'data'])->name('pengeluaran-barang.data');
        Route::get('/pengeluaran-barang', [PengeluaranBarang::class, 'index'])->name('pengeluaran-barang.index');
    });


    Route::group([
        'middleware' => 'role:user'
    ], function () {
        // route permintaan barang
        Route::get('/permintaan-barang/data', [PermintaanBarang::class, 'data'])->name('permintaan-barang.data');
        Route::resource('permintaan-barang', PermintaanBarang::class);
        Route::get('/permintaan-barang/product/{id}', [PermintaanBarang::class, 'getProduct'])->name('permintaan-barang.get_product');
    });
});
