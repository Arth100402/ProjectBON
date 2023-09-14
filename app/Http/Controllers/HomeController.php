<?php

namespace App\Http\Controllers;

use App\Models\Acc;
use App\Models\Bon;
use App\Models\DetailBon;
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
            ->join('departements','users.departement_id','=','departements.id')
            ->where('bons.users_id', '=', Auth::user()->id)
            ->get([
                'bons.*', 'users.id as uid', 'users.name as uname','departements.name as dname'
            ]);
        return response()->json(["data" => $data]);
    }

    public function getDetail(Request $request)
    {
        $id = $request->get('id');
        $data = DetailBon::where('bons_id','=',$id)->get();
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('bon.detail',compact('data'))->render()
        ));
    }

    public function decBon(Request $request, $id)
    {
        $data = Acc::where('bons_id','=',$id);
        $confirmationInput = $request->get('tolak');
        $data->status = 'Tolak';
        $data->keteranganTolak = $confirmationInput;
        $data->save();
        return redirect()->route('vehicle.historyRentAdmin')->with('status', 'Peminjaman telah di tolak');
    }
}
