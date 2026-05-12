<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::resource('struk', App\Http\Controllers\StrukController::class);
Route::resource('pelanggan', App\Http\Controllers\pelangganController::class);