<?php

use App\Http\Controllers\BonController;
use App\Http\Controllers\HomeController;
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
    // BON Controller
    Route::resource('bon', BonController::class);
    Route::get("/loadppc", [BonController::class, "loadPPC"])->name("loadPPC");
    Route::get("/loadsales", [BonController::class, "loadSales"])->name("loadSales");
    Route::post('/getDetail', [BonController::class, 'getDetail'])->name('bon.getDetail');
    Route::get('/jsonShowIndexAdmin', [BonController::class, 'jsonShowIndexAdmin'])->name('bon.jsonShowIndexAdmin');
    Route::get('/getDetailSelf', [BonController::class, 'getDetailSelf'])->name('bon.getDetailSelf');
    Route::get('/jsonShowIndexSelf', [BonController::class, 'jsonShowIndexSelf'])->name('bon.jsonShowIndexSelf');

    // Home Controller
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/index', [HomeController::class, 'showIndex'])->name('index');
    Route::post('/index/getDetail', [HomeController::class, 'getDetail'])->name('home.getDetail');
});
<<<<<<< HEAD
// Route::get("/test", [BonController::class, "getDetailSelf"]);
// Route::get("/test2", [BonController::class, "getDetail"]);

=======
// Route::get("/test", [BonController::class, "test"]);
Route::get("/test", [BonController::class, "getDetail"]);
>>>>>>> d9f0c1a2e3ff721910bf5576894345559f3f75b1
