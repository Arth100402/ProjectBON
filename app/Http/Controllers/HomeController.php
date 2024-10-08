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

    public function redirect()
    {
        if (Auth::user()->jabatan_id == 9) {
            return redirect('/admindashboard');
        }
        return redirect('/bon');
    }
}
