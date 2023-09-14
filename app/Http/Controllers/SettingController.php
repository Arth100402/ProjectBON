<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Jabatan;
use Illuminate\Http\Request;

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
        return response()->json(["jabatans" => $jabatan]);
    }
}
