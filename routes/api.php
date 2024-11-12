<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/sale', [SalesController::class, 'getTopSales'])->name('sale');
Route::get('/trends', [SalesController::class, 'salesTrends'])->name('trends');
