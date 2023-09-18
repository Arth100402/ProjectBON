<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        $data = Departemen::all();
        return view('settingsPage.index', compact('data'));
    }
    public function loadJabatan(Request $request)
    {
        $data = Jabatan::where("name", "LIKE", "%$request->q%")->get();
        return response()->json($data);
    }
    public function populateTable(Request $request)
    {
        $jabatan = Jabatan::all();
        $access = DB::table('acc_access')
            ->where("departId", $request->get("idDepart"))
            ->where("jabatanPengaju", $request->get("idJabatan"))
            ->get();
        return response()->json(["jabatans" => $jabatan, "status" => $access]);
    }
    public function checked(Request $request)
    {
        $aff = DB::table("acc_access")
            ->where("departId", $request->get("depart"))
            ->where("jabatanPengaju", $request->get("aju"))
            ->where("jabatanAcc", $request->get("acc"))
            ->update(["status" => ($request->get("stat") ? "enable" : "disable")]);
        return response()->json($aff);
    }
}
