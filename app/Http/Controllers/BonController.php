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
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('detail')->render()
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
}
