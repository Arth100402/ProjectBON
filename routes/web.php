<?php

use App\Console\Kernel;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\WorkshopController;
use App\Http\Controllers\WebcamController;
use App\Mail\TestEmail;
use App\Models\Project;
use App\Models\Vehicle;
use App\Models\Workshop;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

    // Vehicle
    Route::resource('vehicle', VehicleController::class);
    Route::post('/customvehicle/getDetail', [VehicleController::class, 'getDetail'])->name('vehicle.getDetail');
    Route::get('/customvehicle/historyRentCust', [VehicleController::class, 'historyRentCust'])->name('vehicle.historyRent');
    Route::get('/customvehicle/finishRent/{id}', [VehicleController::class, 'finishRent'])->name('vehicle.finishRent');
    Route::post('/customvehicle/sewaKendaraanFinish/{id}', [VehicleController::class, 'sewaKendaraanFinish'])->name('vehicle.sewaKendaraanFinish');
    Route::get('/customvehicle/pinjam', [VehicleController::class, 'rentVehicle'])->name('vehicle.rent');
    Route::post('/vehicle/sewakendaraan', [VehicleController::class, 'sewaKendaraan'])->name('vehicle.sewaKendaraan');
    Route::get('/customvehicle/historyRentAdmin', [VehicleController::class, 'historyRentAdmin'])->name('vehicle.historyRentAdmin');
    Route::get('/customvehicle/accRent/{id}', [VehicleController::class, 'accRent'])->name('vehicle.accRent');
    Route::post('/customvehicle/jaminan', [VehicleController::class, 'jaminan'])->name('vehicle.jaminan');
    Route::post('/customvehicle/bukti', [VehicleController::class, 'bukti'])->name('vehicle.bukti');
    Route::post('/customvehicle/imagedev', [DeviceController::class, 'imagedev'])->name('vehicle.imagedev');
    Route::post('/customvehicle/imagenota', [VehicleController::class, 'imagenota'])->name('vehicle.imagenota');
    Route::post('/customvehicle/decRent/{id}', [VehicleController::class, 'decRent'])->name('vehicle.decRent');
    Route::get('/customvehicle/admService', [VehicleController::class, 'admService'])->name('vehicle.admService');
    Route::post('/customvehicle/sparepart/', [VehicleController::class, 'sparepart'])->name('vehicle.sparepart');
    Route::get('/sparepartsCariDropDown', [VehicleController::class, 'selectSparepart'])->name("vehicle.cariSparepart");
    Route::get('/bengkelCariDropDown', [VehicleController::class, 'selectBengkel'])->name("vehicle.cariBengkel");
    Route::get('/customvehicle/techService/', [VehicleController::class, 'techService'])->name('vehicle.techService');
    Route::get('/customvehicle/service/', [VehicleController::class, 'service'])->name('vehicle.service');
    Route::post('/customvehicle/serviceMaintenance/', [VehicleController::class, 'serviceMaintenance'])->name('vehicle.serviceMaintenance');
    Route::get('/cariDropDown', [VehicleController::class, 'selectSearch'])->name("vehicleCari");
    Route::get('/cariVehicle', [VehicleController::class, 'selectSearchVehicle'])->name('cariVehicle');
    Route::get('/vehJsonIndex', [VehicleController::class, 'jsonIndex'])->name("vehicle.vehJsonIndex");
    Route::get('/vehJsonTrashIndex', [VehicleController::class, 'jsonTrashIndex'])->name("vehicle.vehJsonTrashIndex");
    Route::post("/vehicle/restore", [VehicleController::class, "vehicleRestore"])->name('vehicle.restore');

    // Calendar
    Route::get('/calendar', [CalendarController::class, "index"])->name("jadwal.index");
    Route::post('/calendar/event/load', [CalendarController::class, "loadEvent"])->name("jadwal.loadevent");
    Route::post('/calendar/event/activity', [CalendarController::class, "detailActivity"])->name("jadwal.detailAct");
    Route::post('/calendar/event/ubah', [CalendarController::class, "loadUbah"])->name("jadwal.ubah");
    Route::post('/calendar/event/insert/{pad}', [CalendarController::class, "insert"])->name("jadwal.createActivity");
    Route::get("/cariProject", [CalendarController::class, "selectSearchProject"])->name("cariProject");
    Route::get('/cariDevice', [CalendarController::class, 'selectSearch'])->name("cariDevice");

    // Timeline
    Route::get("/timeline", [TimelineController::class, "index"])->name("timeline.index");
    Route::post("/timeline/load", [TimelineController::class, "loadTimeline"])->name("timeline.load");
    Route::post('/calendar/event/create', [CalendarController::class, "insert"])->name("jadwal.createActivity");


    //project
    Route::resource('project', ProjectController::class);
    Route::get('/project/trashIndex/reload', [ProjectController::class, 'trashIndex'])->name('project.trashIndex');
    Route::get('/project/backToIndex/reload', [ProjectController::class, 'backToIndex'])->name('project.backToIndex');
    Route::post('/project/getDetail', [ProjectController::class, 'getDetail'])->name('project.getDetail');
    Route::post('/project/getCust', [ProjectController::class, 'getCust'])->name('project.getCust');
    Route::delete('/project/hapusKaryawan/{idProject}/{idUser}', [ProjectController::class, 'hapusKaryawan'])->name('project.hapusKaryawan');
    Route::post('/project/tambahKaryawan', [ProjectController::class, 'tambahKaryawan'])->name('project.tambahKaryawan');
    Route::get('/projectCariDropDown', [ProjectController::class, 'selectSearch'])->name("project.cariKaryawan");
    Route::get('/cariCustomer', [ProjectController::class, "selectSearchCustomer"])->name('cariCustomer');
    Route::post('/project/restore', [ProjectController::class, 'restoreProject'])->name('project.restore');
    Route::post('/project/assignLoad', [ProjectController::class, 'loadProjectAssign'])->name('project.loadAssign');
    Route::get('/assign', [ProjectController::class, 'assignPage']);
    Route::post("/assign/changeRole", [ProjectController::class, 'changeRole'])->name("changeRole");
    Route::post("/assign/showOnHover", [ProjectController::class, "showWaktuHover"])->name("showWaktuHover");
    Route::post("/assign/showPhoto", [ProjectController::class, "showPhoto"])->name("showPhoto");

    //Device
    Route::resource('device', DeviceController::class);
    Route::get('/kategoriCariDropDown', [DeviceController::class, 'selectSearchKategori'])->name("device.cariKategori");
    Route::get('/jsonIndex', [DeviceController::class, 'jsonIndex'])->name("device.jsonIndex");
    Route::get('/jsonTrashIndex', [DeviceController::class, 'trashIndex'])->name("device.jsonTrashIndex");
    Route::post('/device/restore', [DeviceController::class, 'restoreDevice'])->name('device.restore');

    //Dashboard Teknisi
    Route::resource('user', UserController::class);
    Route::post('/user/selectedProject/', [UserController::class, 'selectedProject'])->name("user.selectedProject");
    Route::post('/user/checkin/', [UserController::class, 'checkin'])->name("user.checkin");
    Route::post('/user/checkout/', [UserController::class, 'checkout'])->name("user.checkout");

    //Camera
    Route::get('webcam/{users}/{pad}', [WebcamController::class, 'show'])->name('webcam');
    Route::post('/webcam/capture/{pad}', [WebcamController::class, 'store'])->name('webcam.capture');

    //Workshop
    Route::resource('workshop', WorkshopController::class);
    //Customer
    Route::resource('customer', CustomerController::class);
    Route::get('/jsonShowCustomer', [CustomerController::class, 'jsonShowCustomer'])->name('customer.jsonShowCustomer');
    Route::post('/jsonShowCustomerProject', [CustomerController::class, 'jsonShowCustomerProject'])->name('customer.jsonShowCustomerProject');
    Route::post('/jsonShowSpecCustomer', [CustomerController::class, 'jsonShowSpecCustomer'])->name('customer.jsonShowSpecCustomer');
    Route::post('/jsonShowCustomerProjectDevice', [CustomerController::class, 'jsonShowCustomerProjectDevice'])->name('customer.jsonShowCustomerProjectDevice');
    Route::post('/jsonShowDeviceCategoryProject', [CustomerController::class, 'jsonShowDeviceCategoryProject'])->name('customer.jsonShowDeviceCategoryProject');
    Route::get('/search', [CustomerController::class, 'search'])->name('customer.search');
});
Route::get("/test", [ProjectController::class, 'test']);
Route::get("/token", function () {
    return csrf_token();
});
