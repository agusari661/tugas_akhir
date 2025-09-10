<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EksekutifController;
use App\Http\Controllers\StockBarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\Eksekutif\ProfileEksekutifController;
use App\Http\Controllers\LogBarangKeluarController;
use App\Http\Controllers\StokUpdateController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('index', function () {
    return view('index');
});

// Stock Barang
Route::get('/stok-barang', [StockBarangController::class, 'index'])->name('stokbarang.index');
Route::get('/stok-barang/add', [StockBarangController::class, 'create'])->name('stokbarang.create');
Route::post('/stok-barang/add', [StockBarangController::class, 'store'])->name('stokbarang.store');
Route::get('/stok-barang/edit/{id}/edit', [StockBarangController::class, 'edit'])->name('stokbarang.edit');
Route::put('/stok-barang/edit/{id}', [StockBarangController::class, 'save'])->name('stokbarang.save');
Route::delete('/stok-barang/delete/{id}', [StockBarangController::class, 'delete'])->name('stokbarang.delete');
Route::get('/update-stok', [StokUpdateController::class, 'form'])->name('stok.update.form');
Route::post('/update-stok', [StokUpdateController::class, 'update'])->name('stok.update');

// Data Barang Masuk
Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barangMasuk.index');

// Data Barang Keluar
Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])->name('barangKeluar.index');
Route::get('/barang-keluar/data', [BarangKeluarController::class, 'update'])->name('barangKeluar.update');
Route::put('/barang-keluar/data', [BarangKeluarController::class, 'save'])->name('barangKeluar.save');
Route::get('/log-barangkeluar', [LogBarangKeluarController::class, 'index'])->name('log.barangkeluar');

// Data Supplier
Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
Route::get('/supplier/add', [SupplierController::class, 'create'])->name('supplier.create');
Route::post('/supplier/add', [SupplierController::class, 'store'])->name('supplier.store');
Route::get('/supplier/edit/{id}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
Route::put('/supplier/edit/{id}', [SupplierController::class, 'save'])->name('supplier.save');
Route::delete('/supplier/delete/{id}', [SupplierController::class, 'delete'])->name('supplier.delete');
// Route::patch('/supplier/toggle/{id}', [SupplierController::class, 'toggle'])->name('supplier.toggle');
Route::patch('/supplier/status/{id}', [SupplierController::class, 'toggleStatus'])->name('supplier.toggleStatus');

// Profile Admin
Route::get('profile/{id}', [ProfileEksekutifController::class, 'index'])->name('profile.eksekutif');
Route::post('/profile/update-picture', [ProfileEksekutifController::class, 'updatePicture'])->name('profile.update-picture');
Route::post('/profile/change-password', [ProfileEksekutifController::class, 'changePassword'])->name('profile.change-password');


// Data Admin
Route::get('/data-admin/add', [AdminController::class, 'formAddDataAdmin'])->name('admin.tambah.data');
Route::post('/data-admin/add', [AdminController::class, 'store'])->name('admin.store');
Route::get('/data-admin/edit/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
Route::put('/data-admin/edit/{id}', [AdminController::class, 'save'])->name('admin.save');
Route::delete('/data-admin/delete/{id}', [AdminController::class, 'delete'])->name('admin.delete');
Route::patch('/stokbarang/{id}/toggle-status', [StockBarangController::class, 'toggleStatus'])->name('stokbarang.toggleStatus');

// Admin Routes
Route::prefix('admin')
    ->middleware('auth', 'admin')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        // Route::get('/dashboard/DataAdmin', [AdminController::class, 'ShowDataAdmin'])->name('showData.Admin');

        //cetak PDF
        Route::get('/dashboard/cetak/pdf', [EksekutifController::class, 'cetakPDF'])->name('admin.dashboard.cetak.pdf');
    });

// eksekutif Routes
Route::prefix('eksekutif')
    ->middleware(['auth', 'eksekutif'])
    ->group(function () {
        Route::get('/dashboard', [EksekutifController::class, 'index'])->name('eksekutif.dashboard');
        Route::get('/dashboard/DataEkskutif', [EksekutifController::class, 'ShowDataEkskutif'])->name('showData.Ekskutif');
        Route::get('/dashboard/DataAdmin', [AdminController::class, 'ShowDataAdmin'])->name('showData.Admin');
    });



Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
