<?php

use App\Http\Controllers\{
    CategoryController,
    DashboardController,
    PembelianBarangController,
    PengeluaranBarangController,
    PermintaanBarang,
    ProductController,
    SatuanController,
    SemesterController,
    StokBarangMasukController,
    StokController,
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
    Route::get('/permintaan-barang/product/{id}', [PermintaanBarang::class, 'getProduct'])->name('permintaan-barang.get_product');



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
        Route::get('/pengeluaran-barang/data', [PengeluaranBarangController::class, 'data'])->name('pengeluaran-barang.data');
        Route::get('/pengeluaran-barang', [PengeluaranBarangController::class, 'index'])->name('pengeluaran-barang.index');

        // route pembelian barang
        Route::get('/pembelian-barang/data', [PembelianBarangController::class, 'data'])->name('pembelian-barang.data');
        Route::get('/pembelian-barang/get-data', [PembelianBarangController::class, 'getData'])->name('pembelian-barang.get_data');
        Route::resource('/pembelian-barang', PembelianBarangController::class);
    });


    Route::group([
        'middleware' => 'role:user'
    ], function () {
        // route permintaan barang
        Route::get('/permintaan-barang/data', [PermintaanBarang::class, 'data'])->name('permintaan-barang.data');
        Route::post('/permintaan-barang/pengajuan', [PermintaanBarang::class, 'pengajuan'])->name('permintaan-barang.pengajuan');
        Route::resource('permintaan-barang', PermintaanBarang::class);
    });
});
