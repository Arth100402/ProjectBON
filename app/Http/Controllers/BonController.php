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
            ->join('users', 'bons.users_id', '=', 'users.id')
            ->join('departements', 'users.departement_id', '=', 'departements.id')
            ->where('users.id', '=', Auth::user()->id)
            ->get([
                'bons.id', 'bons.tglPengajuan', 'bons.users_id', 'bons.total', 'bons.status',
                'users.name',
                'departements.name as dname'
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
        $acc = null;
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
        $subquery = DB::table('accs AS a')
            ->join('users AS u', 'a.users_id', '=', 'u.id')
            ->join('jabatans AS j', 'j.id', '=', 'u.jabatan_id')
            ->join('departements AS d', 'd.id', '=', 'u.departement_id')
            ->where('a.bons_id', '=', $id)
            ->select(
                'a.users_id',
                'u.jabatan_id',
                'u.name AS uname',
                'j.name AS jname',
                'd.name AS dname',
                'a.bons_id',
                'a.status as status',
                'a.keteranganTolak as keteranganTolak'
            );

        $acc = DB::table('acc_access AS acc')
            ->join('jabatans AS jab', 'jab.id', '=', 'acc.jabatanAcc')
            ->join('departements AS dep', 'acc.departId', '=', 'dep.id')
            ->leftJoinSub($subquery, 'sq1', function ($join) {
                $join->on('sq1.jabatan_id', '=', 'acc.jabatanAcc');
            })
            ->where('acc.departId', '=', Auth::user()->departement_id)
            ->where('acc.jabatanPengaju', '=', Auth::user()->jabatan_id)
            ->where('acc.status', 'enable')
            ->select(
                'sq1.bons_id AS sq_bons_id',
                'sq1.uname AS uname',
                'jab.name AS jname',
                'dep.name AS dname',
                'sq1.status AS astatus',
                'sq1.keteranganTolak AS aketeranganTolak'
            )
            ->get();

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
    public function fmAcc()
    {
        $bonsFMAccArray = [];

        $dataBons = DB::table('bons')
            ->join('users', 'users.id', '=', 'bons.users_id')
            ->get(['bons.id as bid', 'bons.users_id as idAju', 'users.name as pengaju', 'users.jabatan_id', 'users.departement_id', 'bons.tglPengajuan', 'bons.total']);
        for ($i = 0; $i < count($dataBons); $i++) {
            $dataAcc = DB::table('accs as a')
                ->join('users as uacc', 'uacc.id', '=', 'a.users_id')
                ->where('a.status', 'Terima')
                ->where('a.bons_id', $dataBons[$i]->bid)
                ->count();

            $dataAccess = DB::table('acc_access as aa')
                ->where('aa.departId', $dataBons[$i]->departement_id)
                ->where('aa.status', 'enable')
                ->where('aa.jabatanPengaju', $dataBons[$i]->jabatan_id)
                ->count();
            $comparison_result = $dataAcc === $dataAccess ? 'true' : 'false';
            if ($dataAcc > 0 && $dataAccess > 0 && $comparison_result === 'true') {
                $bonsAdd = [
                    'bid' => $dataBons[$i]->bid,
                    'pengaju' => $dataBons[$i]->pengaju,
                    'tglPengajuan' => $dataBons[$i]->tglPengajuan,
                    'total' => $dataBons[$i]->total
                ];
                array_push($bonsFMAccArray, $bonsAdd);
            }
        }
        return response()->json(["data" => $bonsFMAccArray]);
    }
    public function loadKasir()
    {
        // 3=Manager, 8=Finance
        $data = DB::table("accs AS a")
            ->join("users AS u", "u.id", "=", "a.users_id")
            ->join("jabatans AS j", "j.id", "=", "u.jabatan_id")
            ->join("departements AS d", "d.id", "=", "u.departement_id")
            ->join("bons AS b", "b.id", "a.bons_id")
            ->joinSub(function ($q) {
                $q->select('users.id', 'users.name as uname', 'departements.name as dname')
                    ->from("users")
                    ->join('departements', 'users.departement_id', '=', 'departements.id');
            }, "aju", function ($join) {
                $join->on("aju.id", "=", "b.users_id");
            })
            ->where([["u.jabatan_id", 3], ["u.departement_id", 8], ["a.status", "Terima"]])
            ->get(['aju.uname', 'aju.dname', 'b.tglPengajuan', 'b.total', 'u.name as ACC', 'b.id']);
        return response()->json($data);
    }
    public function getDetailKasir(Request $request)
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
        $acc = Acc::join("users AS u", "u.id", "accs.users_id")
            ->join("jabatans AS j", "j.id", "u.jabatan_id")
            ->join("departements AS d", "d.id", "u.departement_id")
            ->where("bons_id", $id)
            ->get(['u.name as uname', 'j.name as jname', 'd.name as dname', 'accs.status as astatus', 'accs.keteranganTolak as aketeranganTolak']);
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('detail', compact('detail', 'acc'))->render()
        ));
    }

    public function test4()
    {
        dd(User::with("department")->where("id", 1)->get());
    }
}
