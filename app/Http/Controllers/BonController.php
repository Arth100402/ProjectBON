<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\Bon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function jsonShowIndexAdmin()
    {
        // Get all bons
        $data = DB::table('bons')
            ->join('detailbons', 'bons.id', '=', 'detailbons.bons_id')
            ->join('users', 'bons.users_id', '=', 'users.id')
            ->join('projects', 'bons.projects_id', '=', 'projects.id')
            ->join('departements', 'users.departement_id', '=', 'departements.id')
            ->get(['bons.id', 'bons.tglPengajuan', 'bons.users_id', 'users.name', 'departements.name as dname', 'bons.total', 'bons.projects_id', 'projects.idOpti', 'bons.status']);
        return response()->json([
            'data' => $data
        ]);
    }

    public function getDetail(Request $request)
    {
        $id = $request->get('id');
        $detail = DB::table('detailbons')
            ->join('bons', 'detailbons.bons_id', '=', 'bons.id')
            ->join('users', 'bons.users_id', '=', 'users.id')
            ->join('projects', 'bons.projects_id', '=', 'projects.id')
            ->join('departements', 'users.departement_id', '=', 'departements.id')
            ->where('detailbons.bons_id', $id)
            ->get([
                'detailbons.tglMulai', 'detailbons.tglAkhir', 'detailbons.asalKota', 'detailbons.tujuan', 'detailbons.agenda', 'detailbons.keterangan', 'detailbons.kredit', 'detailbons.debit', 'detailbons.totalPengeluaran', 'detailbons.saldo',
                'bons.id', 'bons.tglPengajuan', 'bons.users_id', 'bons.total', 'bons.projects_id', 'bons.status',
                'users.name',
                'departements.name as dname',
                'projects.idOpti'
            ]);
        $acc = DB::table('accs')
            ->join('users', 'accs.users_id', '=', 'users.id')
            ->where('accs.bons_id', $id)
            ->get(['accs.id', 'users.name', 'bons_id as bid', 'accs.status']);
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('detail', compact('detail', 'acc'))->render()
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('formCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::find($request->get("userId"));
        $bon = DB::table('bons')->insertGetId([
            "tglPengajuan" => now(),
            "users_id" => $user->id,
            "total" => $request->get("biayaPerjalanan"),
            "status" => null
        ]);
        foreach ($request->get("select-ppc") as $key => $value) {
            DB::table('detailbons')->insert([
                "bons_id" => $bon,
                "tglMulai" => $request->get("tglMulai")[$key],
                "tglAkhir" => $request->get("tglAkhir")[$key],
                "asalKota" => $request->get("asalKota")[$key],
                "tujuan" => $request->get("tujuan")[$key],
                "users_id" => $request->get("select-sales")[$key],
                "projects_id" => $value,
                "agenda" => $request->get("agenda")[$key],
                "keterangan" => $request->get("keterangan")[$key],
                "kredit" => $request->get("kredit")[$key],
                "debit" => $request->get("debit")[$key],
                "totalPengeluaran" => $request->get("totalPengeluaran")[$key],
                "saldo" => $request->get("saldo")[$key],
            ]);
        }
        return redirect(route('bon.index'));
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
        //
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
        //
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

    public function loadSales(Request $request)
    {
        $data = User::join("departements AS d", "d.id", "users.departement_id")
            ->where("d.id", "5")
            ->where("users.name", "LIKE", "%$request->q%")
            ->get(["users.name", "users.id"]);
        return response()->json(["data" => $data]);
    }
    public function  loadPPC(Request $request)
    {
        $data = Project::where("namaOpti", "LIKE", "%$request->q%")->get(["id", "namaOpti"]);
        return response()->json(["data" => $data]);
    }
    public function test(Request $request)
    {
        return view("test", ["data" => $request]);
    }
}
