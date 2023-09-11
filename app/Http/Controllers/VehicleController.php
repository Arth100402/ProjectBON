<?php

namespace App\Http\Controllers;

use App\Models\DetailMaintenance;
use App\Models\Location;
use App\Models\Maintenance;
use App\Models\RentVehicle;
use App\Models\Sparepart;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Workshop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Vehicle::join('locations', 'vehicles.location_id', '=', 'locations.id')
            ->get(['vehicles.*', 'locations.nama', 'locations.id as lid']);
        return view('vehicle.index', compact('data'));
    }
    public function jsonIndex()
    {
        $data = Vehicle::join('locations', 'vehicles.location_id', '=', 'locations.id')
            ->whereNull('deleted_at')
            ->get(['vehicles.*', 'locations.nama', 'locations.id as lid']);
        return response()->json(["data" => $data]);
    }
    public function jsonTrashIndex()
    {
        $data = Vehicle::join('locations', 'vehicles.location_id', '=', 'locations.id')
            ->withTrashed()
            ->get(['vehicles.*', 'locations.nama', 'locations.id as lid']);
        return response()->json(["data" => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vehicle.formcreate');
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
            'jenisveh' => 'required',
            'merkveh' => ['required', "regex:/^(?!.*\s{2})^(?=.*[A-Za-z0-9])[A-Za-z0-9', .\/#\-+()*[\]]*$/"],
            'tipeveh' => ['required', "regex:/^(?!.*\s{2})^(?=.*[A-Za-z0-9])[A-Za-z0-9', .\/#\-+()*[\]]*$/"],
            'warnaveh' => ['required', "regex:/^(?=.*[A-Za-z])[A-Za-z-]+(?:[ ,][A-Za-z-]+)*$/"],
            'tahunveh' => 'required|integer',
            'nomesinveh' => ['required', "regex:/^(?=.*[A-Za-z0-9])[A-Za-z0-9]+(?: [A-Za-z0-9]+)*$/"],
            'nokerangkaveh' => ['required', "regex:/^(?=.*[A-Za-z0-9])[A-Za-z0-9]+(?: [A-Za-z0-9]+)*$/"],
            'nopolveh' => ['required', "regex:/^(?=.*[A-Za-z0-9])[A-Za-z0-9]+(?: [A-Za-z0-9]+)*$/"],
            'lokasi' => 'required',
            'tglpajakthnVeh' => 'required',
            'masastnkVeh' => 'required',
            'namastnkveh' => ['required', "regex:/^(?=.*[A-Za-z])[A-Za-z]+(?: [A-Za-z]+)*$/"],
            'posbpkbveh' => ['required', "regex:/^(?=.*[A-Za-z])[A-Za-z]+(?: [A-Za-z]+)*$/"],
            'tglkirVeh' => 'required',
            'kodegpsveh' => ['required', "regex:/^(?!.*\s{2})^(?=.*[A-Za-z0-9])[A-Za-z0-9', .\/#\-+()*[\]]*$/"],
            'namagpsveh' => ['required', "regex:/^(?!.*\s{2})^(?=.*[A-Za-z0-9])[A-Za-z0-9', .\/#\-+()*[\]]*$/"],
            'kodebarcodeveh' => ['required', "regex:/^(?!.*\s{2})^(?=.*[A-Za-z0-9])[A-Za-z0-9', .\/#\-+()*[\]]*$/"],
            'tglgpsVeh' => 'required',
        ], [
            'images.required' => 'Gambar belum terisi',
            'images.image' => 'Pastikan anda mengunggah gambar dengan format jpg,png,jpeg dengan ukuran maksimal 2mb',
            'images.mimes' => 'Pastikan anda mengunggah gambar dengan format jpg,png,jpeg dengan ukuran maksimal 2mb',
            'images.max' => 'Pastikan anda mengunggah gambar dengan format jpg,png,jpeg dengan ukuran maksimal 2mb',
            'jenisveh.required' => 'Jenis kendaraan belum terisi.',
            'merkveh.required' => 'Merk kendaraan belum terisi.',
            'merkveh.regex' => "Pastikan format pengisian merk benar.",
            'tipeveh.required' => 'Tipe kendaraan belum terisi.',
            'tipeveh.regex' => "Pastikan format pengisian tipe benar.",
            'warnaveh.required' => 'Warna kendaraan belum terisi.',
            'warnaveh.regex' => "Pastikan format pengisian warna benar.",
            'tahunveh.required' => 'Tahun kendaraan belum terisi.',
            'nomesinveh.required' => 'Nomor mesin kendaraan belum terisi.',
            'nomesinveh.regex' => "Pastikan format pengisian nomor mesin benar.",
            'nokerangkaveh.required' => 'Nomor kerangka kendaraan belum terisi.',
            'nokerangkaveh.regex' => "Pastikan format pengisian nomor kerangka benar.",
            'nopolveh.required' => 'Nomor polisi kendaraan belum terisi.',
            'nopolveh.regex' => "Pastikan format pengisian nomor polisi benar.",
            'lokasi.required' => 'Lokasi kendaraan belum terisi',
            'tglpajakthnVeh.required' => 'Tenggat waktu pajak kendaraan belum terisi.',
            'masastnkVeh.required' => 'Tenggat waktu stnk kendaraan belum terisi.',
            'namastnkveh.required' => 'Atas nama STNK kendaraan belum terisi.',
            'namastnkveh.regex' => "Pastikan format pengisian atas nama STNK benar.",
            'posbpkbveh.required' => 'Nama pemegang BPKB kendaraan belum terisi.',
            'posbpkbveh.regex' => "Pastikan format pengisian nama pemegang BPKB benar.",
            'tglkirVeh.required' => 'Tanggal KIR belum terisi.',
            'kodegpsveh.required' => 'Kode GPS kendaraan belum terisi.',
            'kodegpsveh.regex' => "Pastikan format pengisian kode GPS kendaraan benar.",
            'namagpsveh.required' => 'Nama GPS kendaraan belum terisi.',
            'namagpsveh.regex' => "Pastikan format pengisian nama GPS kendaraan benar.",
            'kodebarcodeveh.required' => 'Kode barcode belum terisi.',
            'kodebarcodeveh.regex' => "Pastikan format pengisian kode barcode benar.",
            'tglgpsVeh.required' => 'Tanggal gps belum terisi.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $imagenamed = "";
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                $imageExt = $image->getClientOriginalExtension();
                $date = now()->format('YmdHis');
                $temp = $date . "vehicle" . $key . "." . $imageExt;
                $image->storeAs('images', $temp, 'public');
                $imagenamed .= $temp . ",";
            }
            $imagenames = rtrim($imagenamed, ",");
        }

        $data = new Vehicle();
        $data->jenis = $request->input('jenisveh');
        $data->merk = $request->input('merkveh');
        $data->tipe = $request->input('tipeveh');
        $data->warna = $request->input('warnaveh');
        $data->tahun = $request->input('tahunveh');
        $data->noMesin = $request->input('nomesinveh');
        $data->noKerangka = $request->input('nokerangkaveh');
        $data->noPol = $request->input('nopolveh');
        $data->location_id = $request->input('lokasi');
        $data->tanggalBayarPajakTahunan = $this->convertDTPtoDatabaseDT($request->input('tglpajakthnVeh'));
        $data->masaBerlakuSTNK = $this->convertDTPtoDatabaseDT($request->input('masastnkVeh'));
        $data->atasNamaSTNK = $request->input('namastnkveh');
        $data->posisiBPKB = $request->input('posbpkbveh');
        $data->tanggalKIR = $this->convertDTPtoDatabaseDT($request->input('tglkirVeh'));
        $data->kodeGPS = $request->input('kodegpsveh');
        $data->namaGPS = $request->input('namagpsveh');
        $data->kodeBarcode = $request->input('kodebarcodeveh');
        $data->tglBayarGPS = $this->convertDTPtoDatabaseDT($request->input('tglgpsVeh'));
        $data->image = $imagenames;
        $data->save();

        return redirect()->route('vehicle.index')->with('status', 'Kendaraan berhasil ditambahkan!');
    }

    private function convertDTPtoDatabaseDT($date)
    {
        return date("Y-m-d", strtotime(str_replace(" ", "", explode(",", $date)[1])));
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
        $data = Vehicle::join('locations', 'vehicles.location_id', '=', 'locations.id')
            ->where('vehicles.id', $id)
            ->get(['vehicles.*', 'locations.nama'])[0];
        return view("vehicle.edit", compact("data"));
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
            'inputNoPol' => ['required', "regex:/^(?=.*[A-Za-z0-9])[A-Za-z0-9]+(?: [A-Za-z0-9]+)*$/"],
            'warna' => ['required', "regex:/^(?=.*[A-Za-z])[A-Za-z-]+(?:[ ,][A-Za-z-]+)*$/"],
            'lokasi' => 'required',
            'jenis' => 'required',
            'tglBayarPajak' => 'required',
            'masaBerlakuSTNK' => 'required',
            'inputAtasNamaSTNK' => ['required', "regex:/^(?=.*[A-Za-z])[A-Za-z]+(?: [A-Za-z]+)*$/"],
            'inputPosisiBPKB' => ['required', "regex:/^(?=.*[A-Za-z])[A-Za-z]+(?: [A-Za-z]+)*$/"],
            'tanggalKIR' => 'required',
            'kodeGPS' => ['required', "regex:/^(?!.*\s{2})^(?=.*[A-Za-z0-9])[A-Za-z0-9', .\/#\-+()*[\]]*$/"],
            'namaGPS' => ['required', "regex:/^(?!.*\s{2})^(?=.*[A-Za-z0-9])[A-Za-z0-9', .\/#\-+()*[\]]*$/"],
            'kodeBarcode' => ['required', "regex:/^(?!.*\s{2})^(?=.*[A-Za-z0-9])[A-Za-z0-9', .\/#\-+()*[\]]*$/"],
            'tglBayarGPS' => 'required',
        ], [
            'inputNoPol.required' => 'Plat nomor kendaraan belum terisi.',
            'inputNoPol.regex' => "Pastikan format pengisian plat nomor benar.",
            'warna.required' => 'Warna kendaraan belum terisi.',
            'warna.regex' => "Pastikan format pengisian warna benar.",
            'lokasi.required' => 'Lokasi kendaraan belum terisi',
            'tglBayarPajak.required' => 'Tenggat waktu pajak kendaraan belum terisi.',
            'masaBerlakuSTNK.required' => 'Tenggat waktu stnk kendaraan belum terisi.',
            'inputAtasNamaSTNK.required' => 'Atas nama STNK kendaraan belum terisi.',
            'inputAtasNamaSTNK.regex' => "Pastikan format pengisian atas nama STNK benar.",
            'inputPosisiBPKB.required' => 'Nama pemegang BPKB kendaraan belum terisi.',
            'inputPosisiBPKB.regex' => "Pastikan format pengisian nama pemegang BPKB benar.",
            'tanggalKIR.required' => 'Tanggal KIR belum terisi.',
            'kodeGPS.required' => 'Kode GPS kendaraan belum terisi.',
            'kodeGPS.regex' => "Pastikan format pengisian kode GPS kendaraan benar.",
            'namaGPS.required' => 'Nama GPS kendaraan belum terisi.',
            'namaGPS.regex' => "Pastikan format pengisian nama GPS kendaraan benar.",
            'kodeBarcode.required' => 'Kode barcode belum terisi.',
            'kodeBarcode.regex' => "Pastikan format pengisian kode barcode benar.",
            'tglBayarGPS.required' => 'Tanggal gps belum terisi.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $file = $request->file('images');
        $oldimage = $request->input('oldimage');
        $images = "";
        if ($file !== null) {
            foreach ($request->file('images') as $key => $image) {
                $imageExt = $image->getClientOriginalExtension();
                $date = now()->format('YmdHis');
                $temp = $date . "vehicle" . $key . "." . $imageExt;
                $image->storeAs('images', $temp, 'public');
                $images .= $temp . ",";
            }
            $imagenames = rtrim($images, ",");
        } else {
            $imagenames = $oldimage;
        }
        $data = Vehicle::find($id);
        if ($data->noPol != $request->input("inputNoPol")) {
            $data->noPolLama = $data->noPol;
            $data->noPol = $request->input("inputNoPol");
        }
        $data->warna = $request->get("warna");
        $data->jenis = $request->get("jenis");
        $data->location_id = $request->get("lokasi");
        $data->tanggalBayarPajakTahunan = $this->convertDTPtoDatabaseDT($request->get("tglBayarPajak"));
        $data->masaBerlakuSTNK = $this->convertDTPtoDatabaseDT($request->get("masaBerlakuSTNK"));
        $data->atasNamaSTNK = $request->get("inputAtasNamaSTNK");
        $data->posisiBPKB = $request->get("inputPosisiBPKB");
        $data->tanggalKIR = $this->convertDTPtoDatabaseDT($request->get("tanggalKIR"));
        $data->kodeGPS = $request->get("kodeGPS");
        $data->namaGPS = $request->get("namaGPS");
        $data->tglBayarGPS = $this->convertDTPtoDatabaseDT($request->get("tglBayarGPS"));
        $data->kodeBarcode = $request->get("kodeBarcode");
        $data->image = $imagenames;
        $data->save();

        return redirect()->route("vehicle.index")->with("status", "Pengubahan Berhasil");
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
            $objVehicle = Vehicle::find($id);
            $objVehicle->delete();
            return redirect()->route('vehicle.index')->with('status', 'Vehicle has been deleted');
        } catch (\PDOException $ex) {
            $msg = "Data Gagal dihapus. Pastikan kembali tidak ada data yang berelasi sebelum dihapus";
            return redirect()->route('vehicle.index')->with('status', $msg);
        }
    }

    public function getDetail(Request $request)
    {
        $id = $request->get('id');
        $data = Vehicle::join('locations', 'vehicles.location_id', '=', 'locations.id')
            ->where('vehicles.id', $id)
            ->get(['vehicles.*', 'locations.nama'])[0];
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('vehicle.detail', compact('data'))->render()
        ));
    }

    public function selectSearch(Request $request)
    {
        $lokasi = [];
        $search = $request->q;
        $lokasi = Location::select("id as lid", "nama")
            ->where('nama', 'LIKE', "%$search%")
            ->get();
        return response()->json($lokasi);
    }

    public function historyRentCust()
    {
        $id = Auth::user()->id;
        $data = User::join('rentvehicle', 'users.id', '=', 'rentvehicle.users_id')
            ->join('vehicles', 'rentvehicle.vehicles_id', '=', 'vehicles.id')
            ->where('rentvehicle.users_id', $id)
            ->selectRaw('CONCAT(vehicles.jenis," ", vehicles.merk," ",vehicles.noPol) as kendaraan, rentvehicle.*')
            ->get();
        return view('rent.custpage', compact('data'));
    }

    public function rentVehicle()
    {
        $datav = Vehicle::all()->where('statusSedia', 'Tersedia');
        $datau = User::all();
        return view('rent.rent', compact('datav', 'datau'));
    }

    public function sewaKendaraan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'vehicleid' => 'required',
            'userid' => 'required',
            'tglsewaVeh' => 'required',
            'tglselesaiVeh' => 'required',
            'tujuanpeminjaman' => ['required', "regex:/^(?!.*\s{2})^(?=.*[A-Za-z0-9])[A-Za-z0-9', .\/#\-+()*[\]]*$/"],
            'statusrentveh' => 'required',
        ], [
            'vehicleid.required' => 'Kendaraan belum terisi.',
            'tujuanpeminjaman.required' => 'Tujuan peminjaman belum terisi.',
            'tujuanpeminjaman.regex' => "Pastikan format pengisian tujuan peminjaman benar.",
            'statusrentveh.required' => 'Status belum terisi.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $imagenamed = "";
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                $imageExt = $image->getClientOriginalExtension();
                $date = now()->format('YmdHis');
                $temp = $date . "jaminan" . $key . "." . $imageExt;
                $image->storeAs('images', $temp, 'public');
                $imagenamed .= $temp . ",";
            }
            $imagenames = rtrim($imagenamed, ",");
        }

        $data = new RentVehicle();
        $data->vehicles_id = $request->input('vehicleid');
        $data->users_id = $request->input('userid');
        $data->tglSewa = $this->convertDTPtoDatabaseDT($request->input('tglsewaVeh'));
        $data->tglSelesai = $this->convertDTPtoDatabaseDT($request->input('tglselesaiVeh'));
        $data->tujuan = $request->input('tujuanpeminjaman');
        $data->status = $request->input('statusrentveh');
        $data->image = $imagenames;
        $data->save();

        return redirect()->route('vehicle.historyRent')->with('status', 'Berhasil membuat form peminjaman kendaraan!');
    }

    public function finishRent($id)
    {
        $data = User::join('rentvehicle', 'users.id', '=', 'rentvehicle.users_id')
            ->join('vehicles', 'rentvehicle.vehicles_id', '=', 'vehicles.id')
            ->where('rentvehicle.id', $id)
            ->selectRaw('CONCAT(vehicles.jenis," ", vehicles.merk," ",vehicles.noPol) as kendaraan, rentvehicle.*')
            ->get()[0];
        return view('rent.rentsuccess', compact('data'));
    }

    public function sewaKendaraanFinish(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'tglselesaiVeh' => 'required',
            'tujuanpeminjaman' => 'required',
            'biayasewa' => 'required',
            'kmawal' => 'required',
            'kmakhir' => 'required',
            'totalliter' => 'required',
            'lokasipengisian' => 'required',
        ], [
            'biayasewa.required' => 'Biaya sewa belum terisi.',
            'kmawal.required' => 'KM awal belum terisi.',
            'kmakhir.required' => 'KM akhir belum terisi.',
            'totalliter.required' => 'Total liter belum terisi.',
            'lokasipengisian.required' => 'Lokasi pengisian belum terisi.',
            'tujuanpeminjaman.required' => 'Tujuan peminjaman belum terisi.',
            'tujuanpeminjaman.regex' => "Pastikan format pengisian tujuan peminjaman benar.",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $imagenamed = "";
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                $imageExt = $image->getClientOriginalExtension();
                $date = now()->format('YmdHis');
                $temp = $date . "km" . $key . "." . $imageExt;
                $image->storeAs('images', $temp, 'public');
                $imagenamed .= $temp . ",";
            }
            $imagenames = rtrim($imagenamed, ",");
        }

        $data = RentVehicle::find($id);
        $data->tglSelesai = $this->convertDTPtoDatabaseDT($request->input("tglselesaiVeh"));
        $data->tujuan = $request->input("tujuanpeminjaman");
        $data->biayaSewa = $request->input("biayasewa");
        $data->kmAwal = $request->input("kmawal");
        $data->kmAkhir = $request->input("kmakhir");
        $data->totalLiter = $request->input("totalliter");
        $data->lokasiPengisian = $request->input("lokasipengisian");
        $data->acc = 'Selesai';
        $data->imagekmawalakhir = $imagenames;

        $vehicle = Vehicle::find($data->vehicles_id);
        $vehicle->statusSedia = "Tersedia";

        $data->save();
        $vehicle->save();

        return redirect()->route('vehicle.historyRent')->with('status', 'Your rent form has been updated successfully.');
    }
    public function test()
    {
        $data = User::with("rentVehicle")->find(1);
        dd($data->rentVehicle);
    }

    public function historyRentAdmin()
    {
        $data = User::join('rentvehicle', 'users.id', '=', 'rentvehicle.users_id')
            ->join('vehicles', 'rentvehicle.vehicles_id', '=', 'vehicles.id')
            ->selectRaw('CONCAT(vehicles.jenis," ", vehicles.merk," ",vehicles.noPol) as kendaraan, users.name as peminjam, rentvehicle.*')
            ->get();
        return view('rent.adminpage', compact('data'));
    }

    public function jaminan(Request $request)
    {
        $id = $request->get('id');
        $data = RentVehicle::find($id);
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('rent.jaminanpage', compact('data'))->render()
        ));
    }

    public function bukti(Request $request)
    {
        $id = $request->get('id');
        $data = RentVehicle::find($id);
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('rent.bukti', compact('data'))->render()
        ));
    }

    public function accRent($id)
    {
        $data = RentVehicle::find($id);
        $data->acc = 'Diterima';
        $data->save();
        $vehicle = Vehicle::find($data->vehicles_id);
        $vehicle->statusSedia = "Dipakai";
        $vehicle->save();
        return redirect()->route('vehicle.historyRentAdmin')->with('status', 'Peminjaman telah di terima');
    }

    public function decRent(Request $request, $id)
    {
        $data = RentVehicle::find($id);
        $confirmationInput = $request->get('tolak');
        $data->acc = 'Ditolak';
        $data->keteranganTolak = $confirmationInput;
        $data->save();
        return redirect()->route('vehicle.historyRentAdmin')->with('status', 'Peminjaman telah di tolak');
    }

    public function admService()
    {
        $data = Maintenance::with('detailMaintenance', 'vehicle', 'user', 'workshop')->get();
        return view('maintenance.adminpage', compact('data'));
    }

    public function sparepart()
    {
        $data = DetailMaintenance::with('sparepart', 'maintenance')->where('maintenances_id', '=', $_POST['id'])->get();
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('maintenance.sparepart', compact('data'))->render()
        ), 200);
    }

    public function imagenota(Request $request)
    {
        $id = $request->get('id');
        $data = Maintenance::find($id);
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('maintenance.image', compact('data'))->render()
        ));
    }

    public function techService()
    {
        $id = Auth::user()->id;
        $data = Maintenance::with('detailMaintenance', 'vehicle', 'workshop')->where('users_id', '=', $id)->get();
        return view('maintenance.custpage', compact('data'));
    }
    public function service()
    {
        $data = Vehicle::all();
        return view('maintenance.service', compact('data'));
    }

    public function selectSparepart(Request $request)
    {
        $sparepart = [];
        $search = $request->q;
        $sparepart = DB::table("spareparts")
            ->where("spareparts.nama", "LIKE", "%$search%")->get();
        return response()->json(["data" => $sparepart, "request" => $request]);
    }

    public function selectBengkel(Request $request)
    {
        $workshop = [];
        $search = $request->q;
        $workshop = DB::table("workshops")
            ->where("workshops.nama", "LIKE", "%$search%")->get();
        return response()->json(["data" => $workshop, "request" => $request]);
    }

    public function selectSearchVehicle(Request $request)
    {
        $search = $request->q;
        $vehicle = Vehicle::where("statusSedia", "Tersedia")
            ->where(function ($query) use ($search) {
                $query->where("jenis", 'LIKE', "%$search%")
                    ->orWhere("merk", 'LIKE', "%$search%")
                    ->orWhere("noPol", 'LIKE', "%$search%");
            })
            ->get();
        return response()->json($vehicle);
    }

    public function serviceMaintenance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'tglserviceVeh' => 'required',
            'keluhanveh' => ['required', "regex:/^(?=.*[A-Za-z])[A-Za-z-]+(?:[ ,][A-Za-z-]+)*$/"],
            'totalbiaya' => ['required', 'regex:/^\+?\d+$/'],
            'serveh' => ['required', 'regex:/^\+?\d+$/'],
            'kmveh' => ['required', 'regex:/^\+?\d+$/'],
            'bengkel' => 'required',
            'userid' => 'required',
            'vehicleid' => 'required',
        ], [
            'images.required' => 'Gambar belum terisi',
            'images.image' => 'Pastikan anda mengunggah gambar dengan format jpg,png,jpeg dengan ukuran maksimal 2mb',
            'images.mimes' => 'Pastikan anda mengunggah gambar dengan format jpg,png,jpeg dengan ukuran maksimal 2mb',
            'images.max' => 'Pastikan anda mengunggah gambar dengan format jpg,png,jpeg dengan ukuran maksimal 2mb',
            'tglserviceVeh.required' => 'Tanggal servis belum terisi.',
            'keluhanveh.required' => 'Keluhan belum terisi.',
            'keluhanveh.regex' => "Pastikan format pengisian keluhan benar.",
            'totalbiaya.required' => 'Total biaya belum terisi.',
            'totalbiaya.regex' => "Pastikan format pengisian total biaya benar.",
            'serveh.required' => 'Harga jasa service belum terisi.',
            'serveh.regex' => "Pastikan format pengisian harga jasa service benar.",
            'kmveh.required' => 'KM kendaraan belum terisi.',
            'kmveh.regex' => "Pastikan format pengisian KM kendaraan benar.",
            'bengkel.required' => 'Bengkel belum dipilih.',
            'userid.required' => 'User belum dipilih.',
            'vehicleid.required' => 'Kendaraan belum dipilih.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $imagenamed = "";
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                $imageExt = $image->getClientOriginalExtension();
                $date = now()->format('YmdHis');
                $temp = $date . "service" . $key . "." . $imageExt;
                $image->storeAs('images', $temp, 'public');
                $imagenamed .= $temp . ",";
            }
            $imagenames = rtrim($imagenamed, ",");
        }

        $data = new Maintenance();
        $data->tglMaintenance = $this->convertDTPtoDatabaseDT($request->input("tglserviceVeh"));
        $data->keluhan = $request->input("keluhanveh");
        $data->totalBiaya = $request->input("totalbiaya");
        $data->hargaService = $request->input('serveh');
        $data->km = $request->input("kmveh");
        $data->workshops_id = $request->input("bengkel");
        $data->users_id = $request->input("userid");
        $data->vehicles_id = $request->input("vehicleid");
        $data->image = $imagenames;
        $data->save();

        $sparepart = $request->input('idsparepart');
        $harga = $request->input('price');

        foreach ($sparepart as $key => $value) {
            $datadetail = new DetailMaintenance();
            $datadetail->spareparts_id = $value;
            $datadetail->subtotal = $harga[$key];
            $datadetail->maintenances_id = $data->id;
            $datadetail->save();
        }

        return redirect()->route('vehicle.techService')->with('status', 'Berhasil membuat form servis!');
    }

    public function vehicleRestore(Request $request)
    {
        $id = $request->get('id');
        $data = Vehicle::join('locations', 'vehicles.location_id', '=', 'locations.id')
            ->where('vehicles.id', $id)
            ->get(['vehicles.*', 'locations.nama']);
        Vehicle::where("id", $id)->withTrashed()->restore();
        return response()->json(["status" => "success", "data" => $data]);
    }
}
