<?php

use App\Http\Controllers\BonController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingController;
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
    Route::resource('/', BonController::class);
    Route::get("/loadppc", [BonController::class, "loadPPC"])->name("loadPPC");
    Route::get("/loadsales", [BonController::class, "loadSales"])->name("loadSales");
    Route::post('/getDetail', [BonController::class, 'getDetail'])->name('bon.getDetail');
    Route::get('/jsonShowIndexAdmin', [BonController::class, 'jsonShowIndexAdmin'])->name('bon.jsonShowIndexAdmin');
    Route::post('/getDetailSelf', [BonController::class, 'getDetailSelf'])->name('bon.getDetailSelf');
    Route::get('/jsonShowIndexSelf', [BonController::class, 'jsonShowIndexSelf'])->name('bon.jsonShowIndexSelf');
    Route::get('/accBont/{id}', [BonController::class, 'accBon'])->name('bon.accBon');
    Route::post('/decBon/{id}', [BonController::class, 'decBon'])->name('bon.decBon');
    Route::get('/HistoryAcc', [BonController::class, 'HistoryAcc'])->name('bon.HistoryAcc');

    // Setting Controller
    Route::get("/hierarchy", [SettingController::class, "index"])->name('setting.index');
    Route::get('/loadHierarchyJabatan', [SettingController::class, "loadJabatan"])->name('setting.loadJabatan');
    Route::post('/populateTable', [SettingController::class, 'populateTable'])->name("setting.populateTable");
});
// Route::get("/test", [BonController::class, "getDetail"]);
