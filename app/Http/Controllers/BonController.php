<?php

namespace App\Http\Controllers;

use App\Models\Acc;
use App\Models\Bon;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Query\JoinClause;
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
        $data = DB::table('bons AS b')
            ->leftJoin('accs AS a', 'b.id', '=', 'a.bons_id')
            ->leftJoin('users AS u', 'u.id', '=', 'b.users_id')
            ->leftJoin('departements AS d', 'd.id', '=', 'u.departement_id')
            ->where(function ($query) {
                $query->whereNotIn('b.id', function ($query) {
                    $query->select('bons_id')->from('accs');
                })
                    ->whereIn('b.users_id', function ($query) {
                        $query->select('id')->from('users')->where('jabatan_id', (Auth::user()->jabatan_id - 1))->where('departement_id', (Auth::user()->departement_id));
                    });
            })
            ->orWhere(function ($query) {
                $query->where('a.status', 'Terima')
                    ->whereIn('a.users_id', function ($query) {
                        $query->select('id')->from('users')->where('jabatan_id', (Auth::user()->jabatan_id - 1))->where('departement_id', (Auth::user()->departement_id));
                    })
                    ->whereNotIn('b.id', function ($query) {
                        $query->select('ac.bons_id')
                            ->from('accs AS ac')
                            ->join('users AS us', 'ac.users_id', '=', 'us.id')
                            ->where('us.jabatan_id', (Auth::user()->jabatan_id));
                    });
            })->get([
                'b.id', 'b.tglPengajuan', 'b.users_id', 'b.total', 'b.status',
                'u.name as name', 'd.name as dname'
            ]);

        return response()->json([
            'data' => $data
        ]);
    }
    public function jsonShowIndexSelf()
    {
        $data = DB::table('bons')
            ->join('detailbons', 'bons.id', '=', 'detailbons.bons_id')
            ->join('users', 'bons.users_id', '=', 'users.id')
            ->join('projects', 'detailbons.projects_id', '=', 'projects.id')
            ->join('departements', 'users.departement_id', '=', 'departements.id')
            ->where('users.id', '=', Auth::user()->id)
            ->get([
                'bons.id', 'bons.tglPengajuan', 'bons.users_id', 'bons.total', 'bons.status',
                'users.name',
                'departements.name as dname',
                'detailbons.projects_id',
                'projects.idOpti'
            ]);
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
            ->join('projects', 'detailbons.projects_id', '=', 'projects.id')
            ->join('departements', 'users.departement_id', '=', 'departements.id')
            ->where('detailbons.bons_id', $id)
            ->get([
                'detailbons.tglMulai', 'detailbons.tglAkhir', 'detailbons.asalKota', 'detailbons.tujuan', 'detailbons.agenda', 'detailbons.biaya', 'detailbons.projects_id', 'detailbons.penggunaan', 'detailbons.noPaket',
                'bons.id', 'bons.tglPengajuan', 'bons.users_id', 'bons.total', 'bons.status',
                'users.name',
                'departements.name as dname',
                'projects.idOpti'
            ]);
        $acc = DB::table('accs')
            ->join('bons', 'accs.bons_id', '=', 'bons.id')
            ->join('users', 'accs.users_id', '=', 'users.id')
            ->join('jabatans', 'users.jabatan_id', '=', 'jabatans.id')
            ->join('departements', 'users.departement_id', '=', 'departements.id')
            ->where('accs.bons_id', '=', $id)
            ->get(['users.name as name', 'jabatans.name as jabatan', 'departements.name as departement', 'accs.status as status', 'accs.keteranganTolak as keteranganTolak']);
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('detail', compact('detail', 'acc'))->render()
        ));
    }
    public function getDetailSelf(Request $request)
    {
        $id = $request->get('id');
        $detail = DB::table('detailbons')
            ->join('bons', 'detailbons.bons_id', '=', 'bons.id')
            ->join('users', 'bons.users_id', '=', 'users.id')
            ->join('projects', 'detailbons.projects_id', '=', 'projects.id')
            ->join('departements', 'users.departement_id', '=', 'departements.id')
            ->where('detailbons.bons_id', '=', $id)
            ->get([
                'detailbons.tglMulai', 'detailbons.tglAkhir', 'detailbons.asalKota', 'detailbons.tujuan', 'detailbons.agenda', 'detailbons.biaya', 'detailbons.projects_id', 'detailbons.penggunaan', 'detailbons.noPaket',
                'bons.id', 'bons.tglPengajuan', 'bons.users_id', 'bons.total', 'bons.status',
                'users.name',
                'projects.idOpti'
            ]);
        $acc = DB::table('acc_access')
            ->leftJoin('users', function (JoinClause $join) {
                $join->on('users.jabatan_id', '=', 'acc_access.jabatanAcc')
                    ->on('users.departement_id', '=', 'acc_access.departId');
            })
            ->leftJoin('accs', 'accs.users_id', '=', 'users.id')
            ->leftJoin('jabatans', 'acc_access.jabatanAcc', '=', 'jabatans.id')
            ->leftJoin('departements', 'acc_access.departId', '=', 'departements.id')
            ->where('acc_access.departId', '=', Auth::user()->departement_id)
            ->where('acc_access.jabatanPengaju', '=', Auth::user()->jabatan_id)
            ->where('acc_access.status', '=', 'enable')
            ->get(['users.name as uname', 'jabatans.name as jname', 'departements.name as dname', 'accs.status as astatus', 'accs.keteranganTolak as aketeranganTolak']);
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
        return view('bon.formCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $bon = DB::table('bons')->insertGetId([
            "tglPengajuan" => now(),
            "users_id" => $user->id,
            "total" => $request->get("biayaPerjalanan"),
            "status" => null
        ]);
        foreach ($request->get("select-ppc") as $key => $value) {
            DB::table('detailbons')->insert([
                "bons_id" => $bon,
                "tglMulai" => $this->convertDTPtoDatabaseDT($request->get("tglMulai")[$key]),
                "tglAkhir" => $this->convertDTPtoDatabaseDT($request->get("tglAkhir")[$key]),
                "asalKota" => $request->get("asalKota")[$key],
                "tujuan" => $request->get("tujuan")[$key],
                "users_id" => $request->get("select-sales")[$key],
                "projects_id" => $value,
                "noPaket" => ($request->get('nopaket')[$key]) ? $request->get('nopaket')[$key] : "tesst",
                "agenda" => $request->get("agenda")[$key],
                "penggunaan" => $request->get("keterangan")[$key],
                "biaya" => $request->get("biaya")[$key],
            ]);
        }
        return redirect(route('index'));
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

    private function convertDTPtoDatabaseDT($date)
    {
        return date("Y-m-d", strtotime(str_replace(" ", "", explode(",", $date)[1])));
    }

    public function accBon($id)
    {
        $data = new Acc();
        $data->bons_id = $id;
        $data->users_id = Auth::user()->id;
        $data->status = 'Terima';
        $data->save();
        return redirect()->route('index')->with('status', 'Bon telah di terima');
    }
    public function HistoryAcc()
    {
        $data = DB::table('accs')
            ->join('bons', 'accs.bons_id', '=', 'bons.id')
            ->join('users', 'users.id', '=', 'bons.users_id')
            ->where('accs.users_id', '=', Auth::user()->id)
            ->get(['bons.tglPengajuan', 'users.name', 'bons.total', 'accs.status', 'accs.keteranganTolak', 'accs.created_at']);
        return response()->json(["data" => $data]);
    }

    public function decBon(Request $request, $id)
    {
        $data = new Acc();
        $confirmationInput = $request->get('tolak');
        $data->bons_id = $id;
        $data->users_id = Auth::user()->id;
        $data->status = 'Tolak';
        $data->keteranganTolak = $confirmationInput;
        $data->save();
        $bon = Bon::find($id);
        $bon->status = "Tolak";
        $bon->save();
        return redirect()->route('index')->with('status', 'Bon telah di tolak');
    }
}
