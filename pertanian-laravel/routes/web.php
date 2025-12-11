<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

// CRUD biasa
Route::resource('categories', CategoryController::class);

// ROUTE PDF — HARUS ADA BARIS INI!
Route::get('/categories/report/pdf', [CategoryController::class, 'generatePDF'])
       ->name('categories.pdf');

Route::get('/', function () {
    return redirect()->route('categories.index');
});