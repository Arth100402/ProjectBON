<?php

use App\Http\Controllers\BonController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingController;
use App\Models\Bon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    Route::get("/", [HomeController::class, 'redirect']);

    // BON Controller
    Route::resource('/bon', BonController::class);
    Route::get("/loadppc", [BonController::class, "loadPPC"])->name("loadPPC");
    Route::get("/loadsales", [BonController::class, "loadSales"])->name("loadSales");
    Route::post('/getDetail', [BonController::class, 'getDetail'])->name('bon.getDetail');
    Route::get('/jsonShowIndexAdmin', [BonController::class, 'jsonShowIndexAdmin'])->name('bon.jsonShowIndexAdmin');
    Route::post('/getDetailSelf', [BonController::class, 'getDetailSelf'])->name('bon.getDetailSelf');
    Route::post('/getDetailHistory', [BonController::class, 'getDetailHistory'])->name('bon.getDetailHistory');
    Route::get('/jsonShowIndexSelf', [BonController::class, 'jsonShowIndexSelf'])->name('bon.jsonShowIndexSelf');
    Route::post('/accBont', [BonController::class, 'accBon'])->name('bon.accBon');
    Route::post('/accBontThres', [BonController::class, 'accBontThres'])->name('bon.accBontThres');
    Route::post('/decBon/{id}', [BonController::class, 'decBon'])->name('bon.decBon');
    Route::post('/revBon/{id}', [BonController::class, 'revBon'])->name('bon.revBon');
    Route::get('/HistoryAcc', [BonController::class, 'HistoryAcc'])->name('bon.HistoryAcc');
    Route::post('/loadDetailBon', [BonController::class, 'loadDetailBon'])->name('bon.loadDetailBon');

    Route::post("/bon/detail/addNew", [BonController::class, 'addNewDetail'])->name("bon.addNewDetail");
    Route::post("/bon/detail/addNewRevision", [BonController::class, 'addNewDetailRevision'])->name("bon.addNewDetailRevision");

    Route::post("/bon/detail/delete", [BonController::class, 'destroyDetail'])->name("bon.destroyDetail");

    // Admin
    Route::get('/admindashboard', [BonController::class, "dashboardAdmin"])->name('admin.dashboard');
    Route::get('/indexAdminShow', [BonController::class, "indexAdmin"])->name('admin.index');
    Route::post('/getDetailAdmin', [BonController::class, 'getDetailAdmin'])->name('bon.getDetailAdmin');
    Route::get('/admincreate', [BonController::class, "admincreate"])->name('admin.create');
    Route::post('/adminstore', [BonController::class, "adminstore"])->name('admin.store');
    Route::post('/accAdmin', [BonController::class, "accAdmin"])->name('admin.accAdmin');


    // FM
    Route::get("/fmindex", [BonController::class, "fmIndex"])->name("fmindex");
    Route::post('/FmAccBon/{id}', [BonController::class, 'FmAccBon'])->name('FmAccBon');
    Route::post('/FmDecBon/{id}', [BonController::class, 'FmDecBon'])->name('FmDecBon');
    Route::post('/FmRevBon/{id}', [BonController::class, 'FmRevBon'])->name('FmRevBon');

    // Kasir
    Route::get("/kasirIndex", [BonController::class, "loadKasir"])->name("kasirIndex");
    Route::get('/accKasir/{id}', [BonController::class, 'accKasir'])->name('accKasir');
    Route::post('/decKasir/{id}', [BonController::class, 'decKasir'])->name('decKasir');
    Route::post('/revKasir/{id}', [BonController::class, 'revKasir'])->name('revKasir');
    Route::post("/kasir/acc/detail", [BonController::class, 'getDetailKasir'])->name("detailKasir");

    // Setting Controller
    Route::get("/hierarchy", [SettingController::class, "index"])->name('setting.index');
    Route::get('/loadHierarchyKaryawan', [SettingController::class, "loadKaryawan"])->name('setting.loadKaryawan');
    Route::get("/loadAcc", [SettingController::class, "loadAcc"])->name("setting.loadAcc");
    Route::post('/populateTable', [SettingController::class, 'populateTable'])->name("setting.populateTable");
    ROUTE::post("/changeCheck", [SettingController::class, 'checked'])->name("setting.checked");
    ROUTE::post("/changeAcc", [SettingController::class, 'updateAcc'])->name("setting.changeAcc");
    ROUTE::post("/upadteThres", [SettingController::class, 'updateThr'])->name("setting.thr");
    ROUTE::post("/upadteThresChange", [SettingController::class, 'updateThrChange'])->name("setting.thrChg");
});
// Route::get("/test", [BonController::class, "jsonShowIndexAdmin"]);
Route::get("/test", [BonController::class, "indexAdmin"]);
// Route::get("/test", function(){
//     return DB::table('detailbons')->where('bons_id',3)->delete();
// });
