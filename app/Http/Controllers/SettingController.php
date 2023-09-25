<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        $data = Departemen::where("id", "!=", 1)
            ->where("id", "!=", 7)
            ->where("id", "!=", 9)->get();
        return view('settingsPage.index', compact('data'));
    }
    public function loadKaryawan(Request $request)
    {
        $data = User::where("name", "LIKE", "%$request->q%")
            ->where("jabatan_id", "!=", 7)
            ->where("jabatan_id", "!=", 8)
            ->where("departement_id", $request->get("idDepart"))
            ->get();
        return response()->json($data);
    }
    public function populateTable(Request $request)
    {
        $access = DB::table('acc_access AS aa')
            ->join("users AS u", "u.id", "aa.idAcc")
            ->where([["idPengaju", $request->get("idKar")], ["departId", $request->get("idPart")]])
            ->orderBy("level")
            ->get(["aa.idAcc", "aa.threshold", "u.name"]);
        return response()->json(["status" => $access]);
    }

    public function updateAcc(Request $request)
    {
        if ($request->get("idAcc") == null) {
            $del = DB::table("acc_access")
                ->where([
                    ["idPengaju", $request->get("idKar")],
                    ["departId", $request->get("idPart")],
                    ["level", $request->get("level")]
                ])->delete();
            return response()->json($del);
        }
        $aff = DB::table('acc_access')
            ->updateOrInsert(
                [
                    "departId" => $request->get("idPart"),
                    "idPengaju" => $request->get("idKar"),
                    "level" => $request->get("level")
                ],
                [
                    "idAcc" => $request->get("idAcc"),
                    "threshold" => $request->get("thres")
                ]
            );
        return response()->json($aff);
    }

    public function updateThr(Request $request)
    {
        $af = DB::table("acc_access")
            ->where([
                ["idPengaju", $request->get("idKar")],
                ["departId", $request->get("idPart")],
                ["level", $request->get("level")],
                ["idAcc", $request->get("idAcc")],
            ])->update(["threshold" => $request->get("thres")]);
        return response()->json($af);
    }

    public function test()
    {
        $access = DB::table('acc_access AS aa')
            ->join("users AS u", "u.id", "aa.idAcc")
            ->where([["idPengaju", 4], ["departId", 4]])
            ->orderBy("level")
            ->get(["aa.idAcc", "aa.threshold", "u.name"]);
        dd($access);
    }
}
