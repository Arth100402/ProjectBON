<?php

namespace App\Http\Controllers;

use App\Models\Bon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function showIndex()
    {
        $data = Bon::join('users', 'bons.users_id', '=', 'users.id')
            ->join('projects', 'bons.projects_id', '=', 'projects.id')
            ->where('bons.users_id', '=', Auth::user()->id)
            ->get([
                'bons.*', 'users.id as uid', 'users.name as uname', 'projects.id as pid', 'projects.idOpti as pidOpti',
                'projects.namaOpti as pnamaOpti'
            ]);
        return response()->json(["data" => $data]);
    }

    public function getDetail(Request $request)
    {
        $id = $request->get('id');
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('detail')->render()
        ));
    }
}
