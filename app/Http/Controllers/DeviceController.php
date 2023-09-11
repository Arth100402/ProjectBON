<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('devices')->join('devicecategory', 'devices.deviceCategory_id', '=', 'devicecategory.id')
            ->whereNull('deleted_at')
            ->get([
                'devices.id', 'devices.nama', 'devicecategory.nama as dcnama', 'devicecategory.id as dcid', 'devices.tipe', 'devices.merk',
                'devices.ipaddress', 'devices.port', 'devices.serialnumber', 'devices.image', 'devices.username', 'devices.password'
            ]);
        return view('device.index', compact('data'));
    }
    public function jsonIndex()
    {
        $data = DB::table('devices')->join('devicecategory', 'devices.deviceCategory_id', '=', 'devicecategory.id')
            ->whereNull('deleted_at')
            ->get([
                'devices.id', 'devices.nama', 'devicecategory.nama as dcnama', 'devicecategory.id as dcid', 'devices.tipe', 'devices.merk',
                'devices.ipaddress', 'devices.port', 'devices.serialnumber', 'devices.image', 'devices.username', 'devices.password'
            ]);
        return response()->json(["data" => $data]);
    }
    public function trashIndex()
    {
        $data = DB::table('devices')->join('devicecategory', 'devices.deviceCategory_id', '=', 'devicecategory.id')
            ->get([
                'devices.id', 'devices.nama', 'devicecategory.nama as dcnama', 'devicecategory.id as dcid', 'devices.tipe', 'devices.merk',
                'devices.ipaddress', 'devices.port', 'devices.serialnumber', 'devices.image', 'devices.username', 'devices.password', 'devices.deleted_at'
            ]);
        return response()->json(["data" => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('device.formcreate');
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
            'images' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nama' => ['required', "regex:/^(?!.*\s{2})^(?=.*[A-Za-z0-9])[A-Za-z0-9', .\/#\-+()*[\]]*$/"],
            'kategori' => 'required',
            'tipe' => ['required', "regex:/^(?!.*\s{2})^(?=.*[A-Za-z0-9])[A-Za-z0-9', .\/#\-+]*$/"],
            'merk' => ['required', "regex:/^(?!.*\s{2})^(?=.*[A-Za-z0-9])[A-Za-z0-9', .\/#\-+]*$/"],
            'ipaddress' => 'nullable|ip',
            'port' => 'nullable|integer',
            'serialnumber' => ['nullable', "regex:/^(?!.*\s{2})^(?=.*[A-Za-z0-9])[A-Za-z0-9', .\/#\-+]*$/"],
            'username' => ['nullable', "regex:/^(?!.*\s{2})[A-Za-z0-9'-.]*[A-Za-z0-9][A-Za-z0-9'-.]*$/"],
            'password' => 'nullable',
        ], [
            'images.required' => 'Gambar belum terisi',
            'images.image' => 'Pastikan anda mengunggah gambar dengan format jpg,png,jpeg dengan ukuran maksimal 2mb',
            'images.mimes' => 'Pastikan anda mengunggah gambar dengan format jpg,png,jpeg dengan ukuran maksimal 2mb',
            'images.max' => 'Pastikan anda mengunggah gambar dengan format jpg,png,jpeg dengan ukuran maksimal 2mb',
            'nama.required' => 'Nama belum terisi.',
            'nama.regex' => "Pastikan format pengisian nama benar.",
            'kategori.required' => 'Kategori belum terisi.',
            'tipe.required' => 'Tipe belum terisi.',
            'tipe.regex' => "Pastikan format pengisian tipe benar.",
            'merk.required' => 'Merk belum terisi.',
            'merk.regex' => "Pastikan format pengisian merk benar.",
            'ipaddress.ip' => "Pastikan format pengisian IP address benar.",
            'port.integer' => 'Pastikan format pengisian port benar.',
            'serialnumber.regex' => "Pastikan format pengisian Serial number benar.",
            'username.regex' => 'Pastikan format pengisian Username benar.',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $imagenamed = "";
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                $imageExt = $image->getClientOriginalExtension();
                $date = now()->format('YmdHis');
                $temp = $date . "device" . $key . "." . $imageExt;
                $image->storeAs('images', $temp, 'public');
                $imagenamed .= $temp . ",";
            }
            $imagenames = rtrim($imagenamed, ",");
        }

        $data = new Device();
        $data->nama = $request->get('nama');
        $data->deviceCategory_id = $request->get('kategori');
        $data->tipe = $request->get('tipe');
        $data->merk = $request->get('merk');
        $data->ipaddress = $request->get('ipaddress');
        $data->port = $request->get('port');
        $data->serialnumber = $request->get('serialnumber');
        $data->username = $request->get('username');
        $data->password = $request->get('password');
        $data->image = $imagenames;
        $data->save();

        return redirect()->route("device.index")->with("status", "Penambahan Berhasil");
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
        $data = Device::join('devicecategory', 'devices.deviceCategory_id', '=', 'devicecategory.id')
            ->where('devices.id', '=', $id)
            ->get(['devices.*', 'devicecategory.nama as dcnama', 'devicecategory.id as dcid'])[0];
        return view('device.edit', compact('data'));
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
        $file = $request->file('images');
        $oldimage = $request->input('oldimage');
        $images = "";
        if ($file !== null) {
            foreach ($request->file('images') as $key => $image) {
                $imageExt = $image->getClientOriginalExtension();
                $date = now()->format('YmdHis');
                $temp = $date . "device" . $key . "." . $imageExt;
                $image->storeAs('images', $temp, 'public');
                $images .= $temp . ",";
            }
            $imagenames = rtrim($images, ",");
        } else {
            $imagenames = $oldimage;
        }
        $validator = Validator::make($request->all(), [
            'images' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nama' => ['required', "regex:/^(?!.*\s{2})^(?=.*[A-Za-z0-9])[A-Za-z0-9', .\/#\-+()*[\]]*$/"],
            'kategori' => 'required',
            'tipe' => ['required', "regex:/^(?!.*\s{2})^(?=.*[A-Za-z0-9])[A-Za-z0-9', .\/#\-+]*$/"],
            'merk' => ['required', "regex:/^(?!.*\s{2})^(?=.*[A-Za-z0-9])[A-Za-z0-9', .\/#\-+]*$/"],
            'ipaddress' => 'nullable|ip',
            'port' => 'nullable|integer',
            'serialnumber' => ['nullable', "regex:/^(?!.*\s{2})^(?=.*[A-Za-z0-9])[A-Za-z0-9', .\/#\-+]*$/"],
            'username' => ['nullable', "regex:/^(?!.*\s{2})[A-Za-z0-9'-.]*[A-Za-z0-9][A-Za-z0-9'-.]*$/"],
            'password' => 'nullable',
        ], [
            'images.required' => 'Gambar belum terisi',
            'images.image' => 'Pastikan anda mengunggah gambar dengan format jpg,png,jpeg dengan ukuran maksimal 2mb',
            'images.mimes' => 'Pastikan anda mengunggah gambar dengan format jpg,png,jpeg dengan ukuran maksimal 2mb',
            'images.max' => 'Pastikan anda mengunggah gambar dengan format jpg,png,jpeg dengan ukuran maksimal 2mb',
            'nama.required' => 'Nama belum terisi.',
            'nama.regex' => "Pastikan format pengisian nama benar.",
            'kategori.required' => 'Kategori belum terisi.',
            'tipe.required' => 'Tipe belum terisi.',
            'tipe.regex' => "Pastikan format pengisian tipe benar.",
            'merk.required' => 'Merk belum terisi.',
            'merk.regex' => "Pastikan format pengisian merk benar.",
            'ipaddress.ip' => "Pastikan format pengisian IP address benar.",
            'port.integer' => 'Pastikan format pengisian port benar.',
            'serialnumber.regex' => "Pastikan format pengisian Serial number benar.",
            'username.regex' => 'Pastikan format pengisian Username benar.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = Device::findOrFail($id);
        $data->nama = $request->input('nama');
        $data->deviceCategory_id = $request->input('kategori');
        $data->tipe = $request->input('tipe');
        $data->merk = $request->input('merk');
        $data->ipaddress = $request->input('ipaddress');
        $data->port = $request->input('port');
        $data->serialnumber = $request->input('serialnumber');
        $data->username = $request->input('username');
        $data->password = $request->input('password');
        $data->image = $imagenames;
        $data->save();

        return redirect()->route("device.index")->with("status", "Pengubahan Berhasil");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $objDevice = Device::find($id);
            $objDevice->delete();
            return redirect()->route('device.index')->with('status', 'Data Barang berhasil dihapus');
        } catch (\PDOException $ex) {
            $msg = "Data Barang gagal dihapus. Pastikan kembali tidak ada data yang berelasi sebelum dihapus";
            return redirect()->route('device.index')->with('status', $msg);
        }
    }

    public function imagedev(Request $request)
    {
        $id = $request->get('id');
        $data = Device::find($id);
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('device.image', compact('data'))->render()
        ));
    }
    public function selectSearchKategori(Request $request)
    {
        $kategori = [];
        $search = $request->q;
        $kategori = DB::table("devicecategory")
            ->where("devicecategory.nama", "LIKE", "%$search%")->get();
        return response()->json($kategori);
    }
    public function restoreDevice(Request $request)
    {
        $id = $request->get('id');
        $data = Device::join('devicecategory', 'devices.deviceCategory_id', '=', 'devicecategory.id')
            ->where('devices.id', '=', $id)
            ->get(['devices.*', 'devicecategory.nama as dcnama', 'devicecategory.id as dcid']);
        Device::where("id", $id)->withTrashed()->restore();
        return response()->json(["status" => "success", "data" => $data]);
    }
}
