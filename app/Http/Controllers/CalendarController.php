<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Project;
use App\Models\ProjectActivityDetail;
use App\Models\ProjectAssign;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Query\Builder;
use PhpParser\Node\Stmt\Foreach_;

class CalendarController extends Controller
{
    public function index()
    {
        return view("jadwal.index");
    }
    public function create()
    {
        return response()->json([
            "data" => view("jadwal.formCreate")->render()
        ]);
    }
    public function insert(Request $request, $pad)
    {
        $data = ProjectActivityDetail::find($pad);
        $data->namaAktifitas = $request->input("namaAktifitas");
        $data->save();

        DB::table('projectassign')
            ->where('projectactivitydetail_id', $pad)
            ->update(['keterangan' => $request->input("keterangan")]);

        $device = $request->input('iddevice');
        $status = $request->input('statuss');
        foreach ($device as $key => $value) {
            DB::table('activitydevice')->insert([
                "projectactivitydetail_id" => $pad,
                "device_id" => $value,
                "status" => $status[$key]
            ]);
        }

        return redirect()->route('user.index')->with('status', 'Aktifitas baru telah ditambahkan');
    }
    public function loadEvent()
    {
        $data = User::join("projectassign AS pa", "pa.users_id", "users.id")
            ->join("projectactivitydetail AS pad", "pad.id", "pa.projectactivitydetail_id")
            ->where("users.id", Auth::user()->id)
            ->get(["pa.users_id", "pa.projectactivitydetail_id AS padId", "pad.namaAktifitas", "pad.tglAktifitas", "pa.waktuTiba", "pa.waktuSelesai"]);
        return response()->json(["status" => "OK", "data" => $data]);
    }
    public function detailActivity(Request $request)
    {
        $idUser = $request->get("idUser");
        $id = $request->get("idPad");
        $data = User::join("projectassign AS pa", "users.id", "=", "pa.users_id")
            ->join("projectactivitydetail AS pad", "pad.id", "=", "pa.projectactivitydetail_id")
            ->join("projects AS p", "pad.projects_id", "=", "p.id")
            ->where("pa.users_id", $idUser)
            ->where("pa.projectactivitydetail_id", $id)
            ->get([
                "users.name", "p.namaOpti", "p.deadline", "p.status",
                "pad.namaAktifitas", "pa.keterangan", "pa.waktuTiba", "pa.waktuSelesai",
                "pad.id AS idPad", "pa.image as image"
            ])[0];
        $devices = DB::table('devices')
            ->join("activitydevice AS ad", "devices.id", "=", "ad.device_id")
            ->join("devicecategory AS dc", "devices.deviceCategory_id", "=", "dc.id")
            ->where("ad.projectactivitydetail_id", $data["idPad"])
            ->whereNull("devices.deleted_at")
            ->get(["devices.nama", "dc.nama AS jenis", "devices.tipe", "ad.status"]);
        return response()->json([
            "data" => view("jadwal.detail", compact("data", "devices"))->render()
        ]);
    }
    public function selectSearch(Request $request)
    {
        $device = [];
        $search = $request->q;
        $device = DB::table("devices")
            ->join('devicecategory AS dc', 'dc.id', 'devices.deviceCategory_id')
            ->where("devices.nama", "LIKE", "%$search%")
            ->whereNull('devices.deleted_at')
            ->get(["devices.nama", 'devices.id', "devices.tipe", "devices.merk", "dc.nama AS jenis"]);
        return response()->json($device);
    }

    public function loadUbah(Request $request)
    {
        $pad = $request->input('pad');
        $data = Project::join('projectactivitydetail', 'projects.id', '=', 'projectactivitydetail.projects_id')
            ->join('projectassign', 'projectassign.projectactivitydetail_id', '=', 'projectactivitydetail.id')
            ->where('projectassign.users_id', '=', Auth::user()->id)
            ->where('projectassign.projectactivitydetail_id', '=', $pad)
            ->get([
                'projects.id as id', 'projects.namaOpti as namaOpti', 'projectactivitydetail.id as pad', 'projectactivitydetail.namaAktifitas as namaAktifitas', 'projectassign.keterangan as keterangan', 'projectassign.waktuTiba as waktuTiba', 'projectassign.waktuSelesai as waktuSelesai'
            ])[0];
        $html = view('user.formCreate', compact('data'))->render();
        return response()->json(['data' => $html, 'value' => $data]);
    }
}
