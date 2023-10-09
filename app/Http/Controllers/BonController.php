<?php

namespace App\Http\Controllers;

use App\Mail\Email;
use App\Mail\revMail;
use App\Models\Acc;
use App\Models\Bon;
use App\Models\DetailBon;
use App\Models\Project;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use function Ramsey\Uuid\v1;

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
        $query = DB::table('bons AS b')
            ->join('users as u', 'b.users_id', '=', 'u.id')
            ->join('accs AS a', 'b.id', '=', 'a.bons_id')
            ->select('a.id', 'b.id', 'u.name', 'b.tglPengajuan', 'b.total', 'a.status', 'a.level')
            ->where('a.users_id', Auth::user()->id)
            ->where('a.status', 'Diproses')
            ->where(function ($query) {
                $query->whereExists(function ($subquery) {
                    $subquery->select('id')
                        ->from('accs AS a1')
                        ->whereColumn('a1.bons_id', 'a.bons_id')
                        ->where('a1.level', DB::raw('a.level - 1'))
                        ->where('a1.status', 'Terima');
                })
                    ->orWhere('a.level', 1);
            })
            ->get();
        $data = $query;

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
        $acc = DB::table('accs')
            ->join('bons', 'bons.id', '=', 'accs.bons_id')
            ->join('users as acc', 'acc.id', '=', 'accs.users_id')
            ->join('users as aju', 'aju.id', '=', 'bons.users_id')
            ->where('bons.users_id', '=', Auth::user()->id)
            ->select('accs.bons_id', 'acc.name as acc_name', 'accs.status', 'accs.keteranganTolak', 'accs.updated_at')
            ->get();
        $x = [];
        $remove = [];
        foreach ($acc as $item) {
            if ($item->status != 'Diproses') {
                array_push($x, $item->bons_id);
            }
            if ($item->status == 'Revisi') {
                array_push($remove, $item->bons_id);
                $x = array_diff($x, $remove);
            }
        }
        foreach ($data as $item) {
            $item->editable = true;
            if (in_array($item->id, $x)) {
                $item->editable = false;
            }
        }
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
            ->leftJoin('projects', 'detailbons.projects_id', '=', 'projects.id')
            ->join('departements', 'users.departement_id', '=', 'departements.id')
            ->where('detailbons.bons_id', '=', $id)
            ->get([
                'detailbons.tglMulai', 'detailbons.tglAkhir', 'detailbons.asalKota', 'detailbons.tujuan', 'detailbons.agenda', 'detailbons.biaya', 'detailbons.projects_id', 'detailbons.penggunaan', 'detailbons.noPaket',
                'bons.id', 'bons.tglPengajuan', 'bons.users_id', 'bons.total', 'bons.status',
                'users.name',
                'projects.idOpti'
            ]);
        $revises = DB::table("revisionhistory")
            ->join("users", "users.id", "revisionhistory.users_id")
            ->where("revisionhistory.bons_id", $id)
            ->get(["users.name AS atasan", "revisionhistory.history", "revisionhistory.created_at AS tglRevisi"]);
        $acc = null;
        $file = Bon::find($id);
        $pdf = ['filename' => $file->file];
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('detail', compact('detail', 'acc', 'pdf', 'revises'))->render()
        ));
    }
    public function getDetailSelf(Request $request)
    {
        $id = $request->get('id');
        $detail = DB::table('detailbons')
            ->join('bons', 'detailbons.bons_id', '=', 'bons.id')
            ->join('users', 'bons.users_id', '=', 'users.id')
            ->leftJoin('projects', 'detailbons.projects_id', '=', 'projects.id')
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
        $acc = DB::table('accs')
            ->join('bons', 'bons.id', '=', 'accs.bons_id')
            ->join('users as acc', 'acc.id', '=', 'accs.users_id')
            ->join('users as aju', 'aju.id', '=', 'bons.users_id')
            ->where('bons.users_id', '=', Auth::user()->id)
            ->where('bons.id', '=', $id)
            ->orderBy("accs.level")
            ->select('acc.name as acc_name', 'acc.jabatan_id as acc_jabatan', 'acc.departement_id as acc_depart', 'accs.status', 'accs.keteranganTolak', 'accs.updated_at')
            ->get();
        $revises = DB::table("revisionhistory")
            ->join("users", "users.id", "revisionhistory.users_id")
            ->where("revisionhistory.bons_id", $id)
            ->get(["users.name AS atasan", "revisionhistory.history", "revisionhistory.created_at AS tglRevisi"]);
        $pdf = null;
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('detail', compact('detail', 'acc', 'pdf', 'revises'))->render()
        ));
    }

    public function getDetailHistory(Request $request)
    {
        $id = $request->get('id');
        $detail = DB::table('detailbons')
            ->join('bons', 'detailbons.bons_id', '=', 'bons.id')
            ->join('users', 'bons.users_id', '=', 'users.id')
            ->leftJoin('projects', 'detailbons.projects_id', '=', 'projects.id')
            ->join('departements', 'users.departement_id', '=', 'departements.id')
            ->where('detailbons.bons_id', '=', $id)
            ->get([
                'detailbons.tglMulai', 'detailbons.tglAkhir', 'detailbons.asalKota', 'detailbons.tujuan', 'detailbons.agenda', 'detailbons.biaya', 'detailbons.projects_id', 'detailbons.penggunaan', 'detailbons.noPaket',
                'bons.id', 'bons.tglPengajuan', 'bons.users_id', 'bons.total', 'bons.status',
                'users.name',
                'projects.idOpti'
            ]);
        $revises = DB::table("revisionhistory")
            ->join("users", "users.id", "revisionhistory.users_id")
            ->where("revisionhistory.bons_id", $id)
            ->get(["users.name AS atasan", "revisionhistory.history", "revisionhistory.created_at AS tglRevisi"]);
        $acc = null;
        $pdf = null;
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('detail', compact('detail', 'acc', 'pdf', 'revises'))->render()
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
        $request->validate([
            'filenames.*' => 'mimes:pdf|max:10240',
        ]);

        $filenames = null;
        $filenamed = "";
        if ($request->hasFile('filenames')) {
            foreach ($request->file('filenames') as $key => $file) {
                $fileExt = $file->getClientOriginalExtension();
                $date = now()->format('YmdHis');
                $temp = $date . "surat" . $key . "." . $fileExt;
                $file->storeAs('files', $temp, 'public');
                $filenamed .= $temp . ",";
            }
            $filenames = rtrim($filenamed, ",");
        }
        $user = User::find(Auth::user()->id);
        $bon = DB::table('bons')->insertGetId([
            "tglPengajuan" => now(),
            "users_id" => $user->id,
            "total" => $request->get("biayaPerjalanan"),
            "status" => null,
            "file" => $filenames
        ]);
        foreach ($request->get("select-sales") as $key => $value) {
            DB::table('detailbons')->insert([
                "bons_id" => $bon,
                "tglMulai" => $this->convertDTPtoDatabaseDT($request->get("tglMulai")[$key]),
                "tglAkhir" => $this->convertDTPtoDatabaseDT($request->get("tglAkhir")[$key]),
                "asalKota" => $request->get("asalKota")[$key],
                "tujuan" => $request->get("tujuan")[$key],
                "users_id" => $request->get("select-sales")[$key],
                "projects_id" => ($request->get("select-ppc")[$key] === 'null') ? null : $request->get("select-ppc")[$key],
                "noPaket" => ($request->get('nopaket')[$key]) ? $request->get('nopaket')[$key] : "tesst",
                "agenda" => $request->get("agenda")[$key],
                "penggunaan" => $request->get("keterangan")[$key],
                "biaya" => $request->get("biaya")[$key],
            ]);
        }
        $datas = DB::table("acc_access")
            ->where([
                ["departId", Auth::user()->departement_id],
                ["idPengaju", Auth::user()->id]
            ])->get();
        for ($i = 0; $i < count($datas); $i++) {
            $newBon = new Acc;
            $newBon->bons_id = $bon;
            $newBon->users_id = $datas[$i]->idAcc;
            $newBon->status = "Diproses";
            $newBon->level = $datas[$i]->level;
            $newBon->save();
            if ($request->get("biayaPerjalanan") < $datas[$i]->threshold) break;
        }

        $query = DB::table('accs as a')
            ->join('users as u', 'a.users_id', '=', 'u.id')
            ->select('a.bons_id', 'u.id', 'u.name', 'a.level', 'u.email')
            ->where('bons_id', $bon)
            ->where('level', 1)
            ->get();
        if ($query->first()) {
            Mail::to($query->first()->email)->send(new Email($query->first()->bons_id, $query->first()->name));
            return redirect()->route('bon.index');
        }
        return redirect()->route('bon.index');
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
        $bon = DB::table('bons')
            ->where('id', $id)->get()[0];
        $data = DB::table('detailbons')
            ->join('projects', 'detailbons.projects_id', '=', 'projects.id')
            ->join('users', 'detailbons.users_id', '=', 'users.id')
            ->where('detailbons.bons_id', $id)
            ->get(['detailbons.*', 'projects.namaOpti', 'projects.noPaket', 'users.name']);
        return view('bon.edit', compact('bon', 'data'));
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
        $request->validate([
            'filenames.*' => 'mimes:pdf|max:10240',
        ]);

        $filenames = null;
        $filenamed = "";
        if ($request->hasFile('filenames')) {
            foreach ($request->file('filenames') as $key => $file) {
                $fileExt = $file->getClientOriginalExtension();
                $date = now()->format('YmdHis');
                $temp = $date . "surat" . $key . "." . $fileExt;
                $file->storeAs('files', $temp, 'public');
                $filenamed .= $temp . ",";
            }
            $filenames = rtrim($filenamed, ",");
        }
        $bon = Bon::find($id);
        $bon->total = $request->get("biayaPerjalanan");
        $bon->save();
        $aff = DB::table('detailbons')->where('bons_id', $id)->delete();
        foreach ($request->get("select-sales") as $key => $value) {
            $data = new DetailBon();
            $data->bons_id = $id;
            $data->tglMulai = $this->convertDTPtoDatabaseDT($request->get("tglMulai")[$key]);
            $data->tglAkhir = $this->convertDTPtoDatabaseDT($request->get("tglAkhir")[$key]);
            $data->asalKota = $request->get("asalKota")[$key];
            $data->tujuan = $request->get("tujuan")[$key];
            $data->users_id = $request->get("select-sales")[$key];
            $data->projects_id = ($request->get("select-ppc")[$key] === 'null') ? null : $request->get("select-ppc")[$key];
            $data->noPaket = ($request->get('nopaket')[$key]) ? $request->get('nopaket')[$key] : "tesst";
            $data->agenda = $request->get("agenda")[$key];
            $data->penggunaan = $request->get("keterangan")[$key];
            $data->biaya = $request->get("biaya")[$key];
            $data->save();
        }

        $change = Acc::where('accs.bons_id', $id)->where('accs.status', 'Revisi')->first();
        $change->status = 'Diproses';


        $query = DB::table('accs')
            ->join('users', 'accs.users_id', '=', 'users.id')
            ->select('accs.bons_id', 'users.email', 'accs.bons_id', 'users.name')
            ->where('accs.bons_id', $id)
            ->where('accs.status', 'Revisi')
            ->get();

        $change->save();


        if ($query->first()) {
            Mail::to($query->first()->email)->send(new revMail($query->first()->bons_id, $query->first()->name));
            return redirect()->route('bon.index');
        } else {
            return redirect()->route('bon.index');
        }
    }

    // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    public function destroyDetail(Request $req)
    {
        $aff = DetailBon::find($req->get("id"))->delete();
        DetailBon::where("detailbons_revision_id", $req->get("id"))->delete();
        return response()->json(["status" => $aff]);
    }
    // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
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
    public function loadDetailBon(Request $request)
    {
        $data = DB::table('detailbons')
            ->leftJoin('projects', 'detailbons.projects_id', '=', 'projects.id')
            ->join('users', 'detailbons.users_id', '=', 'users.id')
            ->where('detailbons.bons_id', $request->get('id'))
            ->whereNull('detailbons.detailbons_revision_id')
            ->get(['detailbons.*', 'projects.namaOpti', 'projects.id AS pid', 'projects.noPaket', 'users.name']);
        $dataRevision = DB::table('detailbons')
            ->leftJoin('projects', 'detailbons.projects_id', '=', 'projects.id')
            ->join('users', 'detailbons.users_id', '=', 'users.id')
            ->where('detailbons.bons_id', $request->get('id'))
            ->whereNotNull('detailbons.detailbons_revision_id')
            ->get(['detailbons.*', 'projects.namaOpti', 'projects.noPaket', 'users.name']);
        return response()->json(compact("data", "dataRevision"));
    }

    public function  loadPPC(Request $request)
    {
        $data = Project::where("namaOpti", "LIKE", "%$request->q%")->get(["id", "namaOpti", "noPaket"]);
        return response()->json(["data" => $data]);
    }

    public function test(Request $request)
    {
        return view("test", ["data" => $request]);
    }

    private function convertDTPtoDatabaseDT($date)
    {
        $exp = explode(",", $date);
        if (count($exp) > 1) {
            return date("Y-m-d", strtotime(str_replace(" ", "", explode(",", $date)[1])));
        }
        return $date;
    }

    public function accBon($id)
    {
        $data = Acc::where('bons_id', $id)
            ->where('users_id', Auth::user()->id)
            ->first();
        $data->status = 'Terima';
        $data->save();
        $query = DB::table('accs as a')
            ->join('users as u', 'a.users_id', '=', 'u.id')
            ->select('a.bons_id', 'u.id', 'u.name', 'a.level', 'u.email')
            ->where('bons_id', $id)
            ->where('level', $data->level + 1)
            ->get();
        if ($query->first()) {
            Mail::to($query->first()->email)->send(new Email($query->first()->bons_id, $query->first()->name));
            return redirect()->route('bon.index')->with('status', 'Bon telah di terima');
        } else {
            return redirect()->route('bon.index')->with('status', 'Bon telah di terima');
        }
    }
    public function HistoryAcc()
    {
        $data = DB::table('accs')
            ->join('bons', 'accs.bons_id', '=', 'bons.id')
            ->join('users', 'users.id', '=', 'bons.users_id')
            ->where('accs.users_id', '=', Auth::user()->id)
            ->where('accs.status', '!=', 'Diproses')
            ->get(['bons.id', 'bons.tglPengajuan', 'users.name', 'bons.total', 'accs.status', 'accs.keteranganTolak', 'accs.keteranganRevisi', 'accs.updated_at']);
        return response()->json(["data" => $data]);
    }

    public function decBon(Request $request, $id)
    {
        $data = Acc::where('bons_id', $id)
            ->where('users_id', Auth::user()->id)
            ->first();
        $confirmationInput = $request->get('tolak');
        $data->status = 'Tolak';
        $data->keteranganTolak = $confirmationInput;
        $data->keteranganRevisi = null;
        $data->save();
        $bon = Bon::find($id);
        $bon->status = "Tolak";
        $bon->save();
        return redirect()->route('bon.index')->with('status', 'Bon telah di tolak');
    }

    public function revBon(Request $request, $id)
    {
        $data = Acc::where('bons_id', $id)
            ->where('users_id', Auth::user()->id)
            ->first();
        $confirmationInput = $request->get('revisi');
        $data->status = 'Revisi';
        $data->keteranganRevisi = $confirmationInput;
        $data->save();
        $history = DB::table('revisionhistory')->insert(
            ['history' => 'Revisi karena ' . $confirmationInput, 'bons_id' => $id, 'users_id' => Auth::user()->id, 'created_at' => now()]
        );

        $query = DB::table('accs')
            ->join('bons', 'accs.bons_id', '=', 'bons.id')
            ->join('users', 'bons.users_id', '=', 'users.id')
            ->select('accs.bons_id', 'users.email', 'accs.bons_id', 'users.name')
            ->where('accs.bons_id', $id)
            ->get();

        if ($query->first()) {
            Mail::to($query->first()->email)->send(new revMail($query->first()->bons_id, $query->first()->name));
            return redirect()->route('bon.index');
        } else {
            return redirect()->route('bon.index');
        }
        return redirect()->route('bon.index')->with('status', 'Bon telah di kembalikan untuk direvisi');
    }

    public function FmAccBon($id)
    {
        $data = new Acc;
        $data->bons_id = $id;
        $data->users_id = Auth::user()->id;
        $data->status = 'Terima';
        $data->level = 6;
        $data->save();
        return redirect()->route('bon.index')->with('status', 'Bon telah di terima');
    }
    public function FmDecBon(Request $request, $id)
    {
        $data = new Acc;
        $data->bons_id = $id;
        $data->users_id = Auth::user()->id;
        $confirmationInput = $request->get('tolak');
        $data->status = 'Tolak';
        $data->keteranganTolak = $confirmationInput;
        $data->level = 6;
        $data->save();
        $bon = Bon::find($id);
        $bon->status = "Tolak";
        $bon->save();
        return redirect()->route('bon.index')->with('status', 'Bon telah di tolak');
    }
    public function fmIndex()
    {
        $acc = DB::table('accs')
            ->join('bons', 'bons.id', '=', 'accs.bons_id')
            ->join('users as acc', 'acc.id', '=', 'accs.users_id')
            ->join('users as aju', 'aju.id', '=', 'bons.users_id')
            ->select('accs.bons_id', 'accs.status', 'acc.departement_id as dname', 'acc.jabatan_id as jabatan')
            ->get();
        $x = [];
        foreach ($acc as $item) {
            if ($item->status != 'Terima' || $item->jabatan == 3 && $item->dname == 8) {
                array_push($x, $item->bons_id);
            }
        }
        $data = DB::table('bons')
            ->join('users', 'bons.users_id', '=', 'users.id')
            ->join('departements', 'users.departement_id', '=', 'departements.id')
            ->join('accs', 'bons.id', '=', 'accs.bons_id')
            ->whereNotIn('bons.id', $x)->distinct()
            ->get([
                'bons.id', 'bons.tglPengajuan', 'bons.users_id', 'bons.total',
                'users.name as pengaju',
                'departements.name as dname'
            ]);
        return response()->json([
            'data' => $data
        ]);
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
            ->whereNotIn('a.bons_id', function ($subquery) {
                $subquery->select('bons_id')
                    ->from('accs')
                    ->join('users', 'users.id', '=', 'accs.users_id')
                    ->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
                    ->where('users.jabatan_id', '=', Auth::user()->jabatan_id);
            })
            ->get(['aju.uname', 'aju.dname', 'b.tglPengajuan', 'b.total', 'u.name as ACC', 'b.status', 'b.id']);
        return response()->json($data);
    }
    public function getDetailKasir(Request $request)
    {
        $id = $request->get('id');
        $detail = DB::table('detailbons')
            ->join('bons', 'detailbons.bons_id', '=', 'bons.id')
            ->join('users', 'bons.users_id', '=', 'users.id')
            ->leftJoin('projects', 'detailbons.projects_id', '=', 'projects.id')
            ->join('departements', 'users.departement_id', '=', 'departements.id')
            ->where('detailbons.bons_id', '=', $id)
            ->get([
                'detailbons.tglMulai', 'detailbons.tglAkhir', 'detailbons.asalKota', 'detailbons.tujuan', 'detailbons.agenda', 'detailbons.biaya', 'detailbons.projects_id', 'detailbons.penggunaan', 'detailbons.noPaket',
                'bons.id', 'bons.tglPengajuan', 'bons.users_id', 'bons.total', 'bons.status',
                'users.name',
                'projects.idOpti'
            ]);
        $acc = DB::table('accs')
            ->join('bons', 'bons.id', '=', 'accs.bons_id')
            ->join('users as acc', 'acc.id', '=', 'accs.users_id')
            ->join('users as aju', 'aju.id', '=', 'bons.users_id')
            ->where('bons.id', '=', $id)
            ->orderBy("accs.level")
            ->select('acc.name as acc_name', 'acc.jabatan_id as acc_jabatan', 'acc.departement_id as acc_depart', 'accs.status', 'accs.keteranganTolak', 'accs.updated_at')
            ->get();
        $pdf = null;
        $revises = DB::table("revisionhistory")
            ->join("users", "users.id", "revisionhistory.users_id")
            ->where("revisionhistory.bons_id", $id)
            ->get(["users.name AS atasan", "revisionhistory.history", "revisionhistory.created_at AS tglRevisi"]);
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('detail', compact('detail', 'acc', 'pdf', 'revises'))->render()
        ));
    }

    public function accKasir($id)
    {
        $data = new Acc();
        $data->bons_id = $id;
        $data->users_id = Auth::user()->id;
        $data->status = 'Terima';
        $data->level = 7;
        $data->save();

        $bon = Bon::find($id);
        $bon->status = "Terima";
        $bon->save();

        return redirect()->route('bon.index')->with('status', 'Bon telah di terima');
    }

    public function test4()
    {
    }
}
