<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectAssign;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Project::join('projectactivitydetail', 'projects.id', '=', 'projectactivitydetail.projects_id')
            ->join('projectassign','projectassign.projectactivitydetail_id','=','projectactivitydetail.id')
            ->where('projectassign.users_id','=',Auth::user()->id)
            ->where('projects.status', 'Proses')
            ->where('projectactivitydetail.tglAktifitas', now()->toDateString())
            ->get([
                'Projects.*', 'projectactivitydetail.id as padid', 'projectactivitydetail.tglAktifitas as padtgl','projectactivitydetail.namaAktifitas as padnama'
            ]);
        return view('user.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function selectedProject(Request $request)
    {
        $selectedValue = $request->input('id');
        $separ = explode(',',$selectedValue);
        $idpad = $separ[1];
        $data = ProjectAssign::where('users_id','=',Auth::user()->id)->where('projectactivitydetail_id','=',$idpad)->get()[0];
        $html = view('user.selected', compact('data'))->render();

        return response()->json(['data' => $html]);
    }

    public function checkin(Request $request)
    {
        $selectedValue = $request->input('id');
        $separ = explode(',',$selectedValue);
        $idpad = $separ[1];
        $update = ProjectAssign::where('users_id','=',Auth::user()->id)
                    ->where('projectactivitydetail_id','=',$idpad)
                    ->update(['waktuTiba' => date('H:i:s')]);
        $data = ProjectAssign::where('users_id','=',Auth::user()->id)->where('projectactivitydetail_id','=',$idpad)->get()[0];
        $html = view('user.selected', compact('data'))->render();

        return response()->json(['data' => $html]);
    }

    public function checkout(Request $request)
    {
        $selectedValue = $request->input('id');
        $separ = explode(',',$selectedValue);
        $idpad = $separ[1];
        $update = ProjectAssign::where('users_id','=',Auth::user()->id)
                    ->where('projectactivitydetail_id','=',$idpad)
                    ->update(['waktuSelesai' => date('H:i:s')]);
        $data = ProjectAssign::where('users_id','=',Auth::user()->id)->where('projectactivitydetail_id','=',$idpad)->get()[0];
        $html = view('user.selected', compact('data'))->render();

        return response()->json(['data' => $html]);
    }
}
