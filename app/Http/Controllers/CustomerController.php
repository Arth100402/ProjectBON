<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customer.index');
    }
    public function jsonShowCustomer()
    {
        $data = DB::table('customers')->get();
        return response()->json(["data" => $data]);
    }
    public function search(Request $request)
    {
        $searchQuery = $request->input('search');
        $cus = Customer::where('nama', 'like', '%' . $searchQuery . '%')->get();
        return response()->json(["data" => $cus]);
    }

    public function jsonShowSpecCustomer(Request $request)
    {
        $data = DB::table('customers')
            ->where('id', '=', $request->get('id'))->get();
        return response()->json(["data" => $data]);
    }
    public function jsonShowCustomerProject(Request $request)
    {
        if ($request->get("projectid") == null) {
            $data = DB::table('projects')
                ->where('customers_id', '=', $request->get("id"))
                ->where('deleted_at', '=', null)
                ->get();
            return response()->json(["data" => $data]);
        } else {
            $data = DB::table('projects')
                ->where('customers_id', '=', $request->get("id"))
                ->where('id', '=', $request->get("projectid"))
                ->where('deleted_at', '=', null)
                ->get();
            return response()->json(["data" => $data]);
        }
    }
    public function jsonShowCustomerProjectDevice(Request $request)
    {
        if ($request->get("projectid") != null) {
            $data = DB::table('activitydevice')
                ->join('projectactivitydetail', 'activitydevice.projectactivitydetail_id', '=', 'projectactivitydetail.id')
                ->join('projects', 'projectactivitydetail.projects_id', '=', 'projects.id')
                ->join('devices', 'activitydevice.device_id', '=', 'devices.id')
                ->join('devicecategory', 'devicecategory.id', '=', 'devices.deviceCategory_id')
                ->where('projects.id', '=', $request->get("projectid"))
                ->get(['devicecategory.id as catid', 'devicecategory.nama as cat', 'activitydevice.device_id', 'devices.nama', 'activitydevice.status']);
            return response()->json(["data" => $data]);
        } else {
            $data = DB::table('activitydevice')
                ->join('projectactivitydetail', 'activitydevice.projectactivitydetail_id', '=', 'projectactivitydetail.id')
                ->join('projects', 'projectactivitydetail.projects_id', '=', 'projects.id')
                ->join('devices', 'activitydevice.device_id', '=', 'devices.id')
                ->join('devicecategory', 'devicecategory.id', '=', 'devices.deviceCategory_id')
                ->where('devices.id', '=', $request->get("deviceid"))
                ->get(['devicecategory.id as catid', 'devicecategory.nama as cat', 'devices.*', 'activitydevice.status']);
            return response()->json(["data" => $data]);
        }
    }
    public function jsonShowDeviceCategoryProject(Request $request)
    {
        if ($request->get("projectid") != null) {
            $data = DB::table('devicecategory')
                ->select('devicecategory.id', 'devicecategory.nama')
                ->distinct()
                ->join('devices', 'devicecategory.id', '=', 'devices.deviceCategory_id')
                ->join('activitydevice', 'activitydevice.device_id', '=', 'devices.id')
                ->join('projectactivitydetail', 'projectactivitydetail.id', '=', 'activitydevice.projectactivitydetail_id')
                ->join('projects', 'projectactivitydetail.projects_id', '=', 'projects.id')
                ->where('projects.id', '=', $request->get("projectid"))
                ->get();
            return response()->json(["data" => $data]);
        } elseif ($request->get("catid") != null) {
            $data = DB::table('activitydevice')
                ->join('projectactivitydetail', 'activitydevice.projectactivitydetail_id', '=', 'projectactivitydetail.id')
                ->join('projects', 'projectactivitydetail.projects_id', '=', 'projects.id')
                ->join('devices', 'activitydevice.device_id', '=', 'devices.id')
                ->join('devicecategory', 'devicecategory.id', '=', 'devices.deviceCategory_id')
                ->where('devicecategory.id', '=', $request->get("catid"))
                ->get(['devicecategory.id as catid', 'devicecategory.nama as cat', 'devices.*', 'activitydevice.status']);
            return response()->json(["data" => $data]);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.formcreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => ['required', "regex:/^(?!.*\s{2})[A-Za-z' .]*[A-Za-z][A-Za-z' .]*$/"],
            'alamat' => ['required', "regex:/^(?!.*\s{2})^(?=.*[A-Za-z0-9])[A-Za-z0-9', .\/#\-+]*$/"],
            'instansi' => ['required', "regex:/^(?!.*\s{2})^(?=.*[A-Za-z0-9])[A-Za-z0-9' .\/]*$/"],
            'notelp' => ['required', 'regex:/^\+?\d+$/', 'max:15'],
            'email' => ['required', 'email'],
        ], [
            'nama.required' => 'Nama belum terisi.',
            'nama.regex' => "Pastikan format pengisian nama benar.",
            'alamat.required' => 'Alamat belum terisi.',
            'alamat.regex' => "Pastikan format pengisian alamat benar.",
            'instansi.required' => 'Instansi belum terisi.',
            'instansi.regex' => "Pastikan format pengisian instansi benar.",
            'notelp.required' => 'Nomor telepon belum terisi.',
            'notelp.regex' => 'Pastikan format pengisian nomor telepon benar.',
            'notelp.max' => 'Nomor telepon tidak boleh lebih dari 15 angka.',
            'email.required' => 'Email belum terisi.',
            'email.email' => 'Pastikan email yang anda isi benar.',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = new Customer();
        $data->nama = $request->input('nama');
        $data->alamat = $request->input('alamat');
        $data->instansi = $request->input('instansi');
        $data->notelp = $request->input('notelp');
        $data->email = $request->input('email');
        $data->save();
        return redirect()->route('customer.index')->with('status', 'Penambahan Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Customer::find($id);
        return view('customer.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => ['required', "regex:/^(?!.*\s{2})[A-Za-z' .]*[A-Za-z][A-Za-z' .]*$/"],
            'alamat' => ['required', "regex:/^(?!.*\s{2})^(?=.*[A-Za-z0-9])[A-Za-z0-9', .\/#\-+]*$/"],
            'instansi' => ['required', "regex:/^(?!.*\s{2})^(?=.*[A-Za-z0-9])[A-Za-z0-9' .\/]*$/"],
            'notelp' => ['required', 'regex:/^\+?\d+$/', 'max:15'],
            'email' => ['required', 'email'],
        ], [
            'nama.required' => 'Nama belum terisi.',
            'nama.regex' => "Pastikan format pengisian nama benar.",
            'alamat.required' => 'Alamat belum terisi.',
            'alamat.regex' => "Pastikan format pengisian alamat benar.",
            'instansi.required' => 'Instansi belum terisi.',
            'instansi.regex' => "Pastikan format pengisian instansi benar.",
            'notelp.required' => 'Nomor telepon belum terisi.',
            'notelp.regex' => 'Pastikan format pengisian nomor telepon benar.',
            'notelp.max' => 'Nomor telepon tidak boleh lebih dari 15 angka.',
            'email.required' => 'Email belum terisi.',
            'email.email' => 'Pastikan email yang anda isi benar.',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = Customer::find($id);
        $data->nama = $request->input('nama');
        $data->alamat = $request->input('alamat');
        $data->instansi = $request->input('instansi');
        $data->notelp = $request->input('notelp');
        $data->email = $request->input('email');
        $data->save();
        return redirect()->route('customer.index')->with('status', 'Pengubahan Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
