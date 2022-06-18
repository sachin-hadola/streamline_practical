<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TreeController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [TreeController::class, 'index'])->name('dashboard');
Route::any('/getmoredata', [TreeController::class, 'getmoredata'])->name('getmoredata');
Route::any('/savedata', [TreeController::class, 'savedata'])->name('savedata');
Route::any('/deleteddata', [TreeController::class, 'deleteddata'])->name('deleteddata');
