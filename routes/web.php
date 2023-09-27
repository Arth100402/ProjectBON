<?php

use App\Http\Controllers\BonController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingController;
use App\Models\Bon;
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
    Route::post('/getDetailHistory', [BonController::class, 'getDetailHistory'])->name('bon.getDetailHistory');
    Route::get('/jsonShowIndexSelf', [BonController::class, 'jsonShowIndexSelf'])->name('bon.jsonShowIndexSelf');
    Route::get('/accBont/{id}', [BonController::class, 'accBon'])->name('bon.accBon');
    Route::post('/decBon/{id}', [BonController::class, 'decBon'])->name('bon.decBon');
    Route::get('/HistoryAcc', [BonController::class, 'HistoryAcc'])->name('bon.HistoryAcc');

    // FM
    Route::get("/fmindex", [BonController::class, "fmIndex"])->name("fmindex");

    // Kasir
    Route::get("/kasirIndex", [BonController::class, "loadKasir"])->name("kasirIndex");
    Route::get('/accKasir/{id}', [BonController::class, 'accKasir'])->name('accKasir');
    Route::post("/kasir/acc/detail", [BonController::class, 'getDetailKasir'])->name("detailKasir");

    // Setting Controller
    Route::get("/hierarchy", [SettingController::class, "index"])->name('setting.index');
    Route::get('/loadHierarchyKaryawan', [SettingController::class, "loadKaryawan"])->name('setting.loadKaryawan');
    Route::get("/loadAcc", [SettingController::class, "loadAcc"])->name("setting.loadAcc");
    Route::post('/populateTable', [SettingController::class, 'populateTable'])->name("setting.populateTable");
    ROUTE::post("/changeCheck", [SettingController::class, 'checked'])->name("setting.checked");
    ROUTE::post("/changeAcc", [SettingController::class, 'updateAcc'])->name("setting.changeAcc");
    ROUTE::post("/upadteThres", [SettingController::class, 'updateThr'])->name("setting.thr");
});
// Route::get("/test", [BonController::class, "jsonShowIndexAdmin"]);
// Route::get("/test", [BonController::class, "jsonShowIndexSelf"]);
Route::get("/test", [BonController::class, "test4"]);
