<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BackOffice\DashboardController;
use App\Http\Controllers\BackOffice\UserController;
use App\Http\Controllers\BackOffice\CategoryController;
use App\Http\Controllers\BackOffice\PurchaseController;
use App\Http\Controllers\BackOffice\SubCategoryController;
use App\Http\Controllers\BackOffice\SupplierController;
use App\Http\Controllers\BackOffice\PeminjamanController;
use App\Http\Controllers\SiteController;
use App\Models\Voucher;

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


Route::get('/', [SiteController::class, 'index'])->name('home');
Route::middleware(['auth',  'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', [UserController::class, 'profile'])->name('profile');
    Route::post('/profil', [UserController::class, 'updateProfile']);
    Route::resource('user', UserController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('purchase', PurchaseController::class);
    Route::resource('peminjaman', PeminjamanController::class);
    // purchase.print
    Route::get('purchase/{purchase}/print', [PurchaseController::class, 'print'])->name('purchase.print');
    Route::get('purchase/{purchase}/nota', [PurchaseController::class, 'nota'])->name('purchase.nota');
    Route::get('purchaseallPrint', [PurchaseController::class, 'allPrint'])->name('purchase.allPrint');
    Route::get('purchaseReport', [PurchaseController::class, 'report'])->name('purchase.report');
    Route::post('payment/{id}', [PeminjamanController::class, 'approveTransaction']);
    Route::post('paymentUpdate/{id}', [PeminjamanController::class, 'updatePaymentDetail']);
    Route::post('exportPeminjaman', [PeminjamanController::class, 'exportTransaction']);
    Route::resource('sub_category', SubCategoryController::class);

});
