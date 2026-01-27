<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DepreciationPdfController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::post('/product/temp-image-clear', function () {
    if (session()->has('temp_image_path')) {
        Storage::disk('public')->delete(session('temp_image_path'));
        session()->forget(['temp_image_path', 'temp_image_url']);
    }

    return response()->noContent();
})->name('product.temp.clear');
Route::get('/product/temp-image-cancel', function () {
    
    if (session()->has('temp_image_path')) {
        Storage::disk('public')->delete(session('temp_image_path'));
        session()->forget(['temp_image_path', 'temp_image_url']);
    }

    return redirect()->route('product.index');
})->name('product.temp.cancel');

Route::get('/home', [HomeController::class, 'index'])->name('home');

// this is for the product 
Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/datatable', [ProductController::class, 'datatable'])->name('product.datatable');
Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
Route::post('/product', [ProductController::class, 'store'])->name('product.store');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
Route::put('/product/{product}', [ProductController::class, 'update'])->name('product.update');
Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
Route::post('/product/temp-upload', [ProductController::class, 'tempUpload'])
    ->name('product.temp.upload');
Route::get('/product/depreciation/export', [ProductController::class, 'exportDepreciation'])->name('product.depreciation.export');

//this is for the categories
Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::get('/category/datatable', [CategoryController::class, 'datatable'])->name('category.datatable');
Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
Route::get('/category/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
Route::put('/category/{category}', [CategoryController::class, 'update'])->name('category.update');
Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

//this is for the settings
Route::get('/setting', [SettingController::class, 'edit'])->name('setting.edit');
Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');

// this is for exporting the products Depreciation details 
Route::get('/depreciation/pdf/view', [DepreciationPdfController::class, 'view'])->name('depreciation.pdf.view');
Route::get('/depreciation/pdf/download', [DepreciationPdfController::class, 'download'])->name('depreciation.pdf.download');