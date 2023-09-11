<?php

use App\Http\Controllers\BonController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\XmlConfiguration\Group;

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

Auth::routes();
Route::middleware("auth")->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('bon', BonController::class);
    Route::get("/loadppc", [BonController::class, "loadPPC"])->name("loadPPC");
    Route::get("/loadsales", [BonController::class, "loadSales"])->name("loadSales");
});
Route::get("/test", [BonController::class, "loadSales"]);
