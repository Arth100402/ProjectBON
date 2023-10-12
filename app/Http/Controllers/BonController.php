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
use Illuminate\Support\Facades\Validator;

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
            ->select('a.id', 'b.id', 'u.name', 'b.tglPengajuan', 'b.total', 'a.status', 'a.level', 'a.threshold')
            ->where('a.users_id', Auth::user()->id)
            ->where('a.status', 'Diproses')
            ->where(function ($query) {
                $query->whereExists(function ($subquery) {
                    $subquery->select('id')
                        ->from('accs AS a1')
                        ->whereColumn('a1.bons_id', 'a.bons_id')
                        ->where('a1.level', DB::raw('a.level - 1'))
                        ->where('a1.status', 'Terima');
                })->orWhere('a.level', 1);
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
            ->select('accs.bons_id', 'acc.name as acc_name', 'accs.status', 'accs.level', 'accs.keteranganTolak', 'accs.updated_at')
            ->get();
        $x = [];
        $remove = [];
        $level = [];
        foreach ($acc as $item) {
            if ($item->status != 'Diproses') {
                array_push($x, $item->bons_id);
            }
            if ($item->status == 'Revisi') {
                array_push($remove, $item->bons_id);
                $x = array_diff($x, $remove);
            }
            if ($item->level == 0 && $item->status == 'Diproses') {
                array_push($level, $item->bons_id);
            }
        }

        foreach ($data as $item) {
            $item->editable = true;
            $item->ktt = false;
            if (in_array($item->id, $x)) {
                $item->editable = false;
            }
            if (in_array($item->id, $level)) {
                $item->ktt = true;
            }
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function dashboardAdmin()
    {
        return view('admin.home');
    }

    public function indexAdmin()
    {
        $data = DB::table('bons')
            ->join('users', 'bons.users_id', '=', 'users.id')
            ->join('departements', 'users.departement_id', '=', 'departements.id')
            ->where('users.departement_id', '=', Auth::user()->departement_id)
            ->get([
                'bons.id', 'bons.tglPengajuan', 'bons.users_id', 'bons.total', 'bons.status',
                'users.name',
                'departements.name as dname'
            ]);
        $acc = collect();

        foreach ($data as $item) {
            $acc->push(
                DB::table('accs')
                    ->join('bons', 'bons.id', '=', 'accs.bons_id')
                    ->join('users as acc', 'acc.id', '=', 'accs.users_id')
                    ->join('users as aju', 'aju.id', '=', 'bons.users_id')
                    ->where('bons.users_id', '=', $item->users_id)
                    ->select('accs.bons_id', 'acc.name as acc_name', 'accs.status', 'accs.keteranganTolak', 'accs.updated_at')
                    ->get()
            );
        }

        $x = [];
        $remove = [];

        foreach ($acc as $items) {
            foreach ($items as $item) {
                if ($item->status != 'Diproses') {
                    array_push($x, $item->bons_id);
                }
                if ($item->status == 'Revisi') {
                    array_push($remove, $item->bons_id);
                }
            }
        }

        $x = array_diff($x, $remove);

        foreach ($data as $item) {
            $item->editable = true;
            if (in_array($item->id, $x, true)) {
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
                'detailbons.tglMulai', 'detailbons.tglAkhir', 'detailbons.asalKota', 'detailbons.tujuan', 'detailbons.agenda', 'detailbons.biaya', 'detailbons.projects_id', 'detailbons.penggunaan', 'detailbons.noPaket', 'detailbons.deleted_at',
                'bons.id', 'bons.tglPengajuan', 'bons.users_id', 'bons.total', 'bons.status',
                'users.name',
                'projects.idOpti'
            ]);
        $revises = DB::table("revisionhistory")
            ->join("users", "users.id", "revisionhistory.users_id")
            ->where("revisionhistory.bons_id", $id)
            ->get(["users.name AS atasan", "revisionhistory.history", "revisionhistory.created_at AS tglRevisi"]);
        $acc = DB::table('accs')
            ->join('bons', 'bons.id', '=', 'accs.bons_id')
            ->join('users as acc', 'acc.id', '=', 'accs.users_id')
            ->join('users as aju', 'aju.id', '=', 'bons.users_id')
            ->where('bons.id', '=', $id)
            ->orderBy("accs.level")
            ->select('acc.name as acc_name', 'acc.jabatan_id as acc_jabatan', 'acc.departement_id as acc_depart', 'accs.status', 'accs.keteranganTolak', 'accs.keteranganAcc', 'accs.updated_at')
            ->get();
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
                'detailbons.tglMulai', 'detailbons.tglAkhir', 'detailbons.asalKota', 'detailbons.tujuan', 'detailbons.agenda', 'detailbons.biaya', 'detailbons.projects_id', 'detailbons.penggunaan', 'detailbons.noPaket', 'detailbons.deleted_at',
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
            ->select('acc.name as acc_name', 'acc.jabatan_id as acc_jabatan', 'acc.departement_id as acc_depart', 'accs.status', 'accs.keteranganTolak', 'accs.keteranganAcc', 'accs.updated_at')
            ->get();
        $revises = DB::table("revisionhistory")
            ->join("users", "users.id", "revisionhistory.users_id")
            ->where("revisionhistory.bons_id", $id)
            ->get(["users.name AS atasan", "revisionhistory.history", "revisionhistory.created_at AS tglRevisi"]);
        $file = Bon::find($id);
        $pdf = ['filename' => $file->file];
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('detail', compact('detail', 'acc', 'pdf', 'revises'))->render()
        ));
    }

    public function getDetailAdmin(Request $request)
    {
        $id = $request->get('id');
        $users_id = $request->get('users_id');
        $detail = DB::table('detailbons')
            ->join('bons', 'detailbons.bons_id', '=', 'bons.id')
            ->join('users', 'bons.users_id', '=', 'users.id')
            ->leftJoin('projects', 'detailbons.projects_id', '=', 'projects.id')
            ->join('departements', 'users.departement_id', '=', 'departements.id')
            ->where('detailbons.bons_id', '=', $id)
            ->get([
                'detailbons.tglMulai', 'detailbons.tglAkhir', 'detailbons.asalKota', 'detailbons.tujuan', 'detailbons.agenda', 'detailbons.biaya', 'detailbons.projects_id', 'detailbons.penggunaan', 'detailbons.noPaket', 'detailbons.deleted_at',
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
            ->where('bons.users_id', '=', $users_id)
            ->where('bons.id', '=', $id)
            ->orderBy("accs.level")
            ->select('acc.name as acc_name', 'acc.jabatan_id as acc_jabatan', 'acc.departement_id as acc_depart', 'accs.status', 'accs.keteranganTolak', 'accs.keteranganAcc', 'accs.updated_at')
            ->get();
        $revises = DB::table("revisionhistory")
            ->join("users", "users.id", "revisionhistory.users_id")
            ->where("revisionhistory.bons_id", $id)
            ->get(["users.name AS atasan", "revisionhistory.history", "revisionhistory.created_at AS tglRevisi"]);
        $file = Bon::find($id);
        $pdf = ['filename' => $file->file];
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
                'detailbons.tglMulai', 'detailbons.tglAkhir', 'detailbons.asalKota', 'detailbons.tujuan', 'detailbons.agenda', 'detailbons.biaya', 'detailbons.projects_id', 'detailbons.penggunaan', 'detailbons.noPaket', 'detailbons.deleted_at',
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bon.formCreate');
    }

    public function admincreate()
    {
        return view('admin.formCreate');
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
            'filenames.*' => 'mimes:jpg,jpeg,png,pdf,docx|max:10240',
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
                "noPaket" => ($request->get('nopaket')[$key]) ? $request->get('nopaket')[$key] : null,
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
            $newBon->threshold = $datas[$i]->threshold;
            $newBon->thresholdChange = $datas[$i]->thresholdChange;
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

    public function adminstore(Request $request)
    {
        $request->validate([
            'filenames.*' => 'mimes:jpg,jpeg,png,pdf,docx|max:10240',
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
        $user = User::find($request->get('select-sales')[0]);
        if ($user) {
            $bon = DB::table('bons')->insertGetId([
                "tglPengajuan" => now(),
                "users_id" => $user->id,
                "total" => $request->get("biayaPerjalanan"),
                "status" => null,
                "file" => $filenames
            ]);

            if ($bon) {
                foreach ($request->get("select-sales") as $key => $value) {
                    DB::table('detailbons')->insert([
                        "bons_id" => $bon,
                        "tglMulai" => $this->convertDTPtoDatabaseDT($request->get("tglMulai")[$key]),
                        "tglAkhir" => $this->convertDTPtoDatabaseDT($request->get("tglAkhir")[$key]),
                        "asalKota" => $request->get("asalKota")[$key],
                        "tujuan" => $request->get("tujuan")[$key],
                        "users_id" => $request->get("select-sales")[$key],
                        "projects_id" => ($request->get("select-ppc")[$key] === 'null') ? null : $request->get("select-ppc")[$key],
                        "noPaket" => ($request->get('nopaket')[$key]) ? $request->get('nopaket')[$key] : null,
                        "agenda" => $request->get("agenda")[$key],
                        "penggunaan" => $request->get("keterangan")[$key],
                        "biaya" => $request->get("biaya")[$key],
                    ]);
                }

                $newBon = new Acc;
                $newBon->bons_id = $bon;
                $newBon->users_id = $user->id;
                $newBon->status = "Diproses";
                $newBon->level = 0;
                $newBon->threshold = 0;
                $newBon->save();

                Mail::to($user->email)->send(new Email($bon, $user->name));
            }
        }
        return redirect()->route('admin.dashboard');
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
            ->join('users', 'bons.users_id', '=', 'users.id')
            ->select('bons.*', 'users.name')
            ->where('bons.id', $id)->get()[0];
        $data = DB::table('detailbons')
            ->join('projects', 'detailbons.projects_id', '=', 'projects.id')
            ->join('users', 'detailbons.users_id', '=', 'users.id')
            ->where('detailbons.bons_id', $id)
            ->get(['detailbons.*', 'projects.namaOpti', 'projects.noPaket', 'users.name']);
        $level1 = Acc::where("bons_id", $id)->where("level", 1)->orWhere("level", 0)->first("status")["status"] == "Diproses";
        return view('bon.edit', compact('bon', 'data', 'level1'));
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
        $validator = Validator::make(
            $request->all(),
            [
                'filenames.*' => 'mimes:pdf|max:10240',
                'biayaPerjalanan' => 'required|integer',
            ],
            [
                'filenames.mimes' => 'Pastikan anda mengunggah file dengan format pdf',
                'filenames.max' => 'Pastikan anda mengunggah file dengan ukuran maksimal 10MB',
                'biayaPerjalanan.required' => 'Biaya perjalanan harus diisi',
                'biayaPerjalanan.integer' => 'Biaya perjalanan harus berupa angka',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

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

        $userbon = DB::table('bons')->join('users', 'bons.users_id', '=', 'users.id')->select('bons.*', 'users.name', 'users.email', 'users.id as uid', 'users.departement_id as depid')
            ->where('bons.id', $id)->first();

        $query = DB::table('accs')
            ->join('users', 'accs.users_id', '=', 'users.id')
            ->select('accs.bons_id', 'users.email', 'accs.bons_id', 'users.name', 'accs.thresholdChange', 'accs.level', 'accs.status')
            ->where('accs.bons_id', $id)
            ->where('accs.status', 'Revisi')
            ->get();
        $query2 = DB::table('accs')
            ->join('users', 'accs.users_id', '=', 'users.id')
            ->select('accs.bons_id', 'users.email', 'accs.bons_id', 'users.name', 'accs.thresholdChange', 'accs.level', 'accs.status')
            ->where('accs.bons_id', $id)
            ->where('accs.level', 0)
            ->get();
        $levelTertinggi = DB::table('accs')
            ->join('users', 'accs.users_id', '=', 'users.id')
            ->select('accs.bons_id', 'users.email', 'accs.bons_id', 'users.name', 'accs.thresholdChange', 'accs.threshold', 'accs.level', 'accs.status')
            ->where('accs.bons_id', $id)
            ->orderBy('accs.level', 'desc')
            ->first();

        if (Auth::user()->jabatan_id == 9) {
            $bon = Bon::find($id);
            $change = Acc::where('accs.bons_id', $id)->where('accs.status', 'Revisi')->orWhere('accs.status', 'Terima')->get();
            foreach ($change as $item) {
                $item->status = 'Diproses';
                $item->save();
            }
            if ($query2) {
                $query2->first()->status = "Diproses";
            } else {
                $newBon = new Acc;
                $newBon->bons_id = $bon;
                $newBon->users_id = $bon->users_id;
                $newBon->status = "Diproses";
                $newBon->level = 0;
                $newBon->save();
            }
            $bon->total = $request->get("biayaPerjalanan");
            $bon->save();
            Mail::to($userbon->email)->send(new revMail($userbon->id, $userbon->name));
            return redirect()->route('bon.index');
        } else {
            $bon = Bon::find($id);
            //apabila melebihi threshold level tertinggi maka tambah atasan
            if ($request->get("biayaPerjalanan") > $levelTertinggi->threshold) {
                $datas = DB::table("acc_access")
                    ->where([
                        ["departId", $userbon->depid],
                        ["idPengaju", $userbon->uid]
                    ])->get();
                for ($i = 0; $i < count($datas); $i++) {
                    if ($datas[$i]->threshold > $request->get("biayaPerjalanan")) {
                        $newAcc = new Acc;
                        $newAcc->bons_id = $id;
                        $newAcc->users_id = $datas[$i]->users_id;
                        $newAcc->status = "Diproses";
                        $newAcc->level = $datas[$i]->level;
                        $newAcc->threshold = $datas[$i]->threshold;
                        $newAcc->thresholdChange = $datas[$i]->thresholdChange;
                        $newAcc->save();
                        break;
                    }
                }
            }
            //apabila biaya perjalanan melebihi threshold change perevisi maka reset penerimaan
            if ($request->get("biayaPerjalanan") > $query->first()->thresholdChange) {
                $change = Acc::where('accs.bons_id', $id)->where('accs.status', 'Revisi')->orWhere('accs.status', 'Terima')->orWhere('accs.level', '!=', 0)->get();
                foreach ($change as $item) {
                    if ($item->level == 0) continue;
                    $item->status = 'Diproses';
                    $item->save();
                }
                $bon->total = $request->get("biayaPerjalanan");
            } else {
                $change = Acc::where('accs.bons_id', $id)->where('accs.status', 'Revisi')->first();
                $change->status = 'Diproses';
                $change->save();
                $bon->total = $request->get("biayaPerjalanan");
            }

            $bon->save();
            if ($query->first()) {
                Mail::to($query->first()->email)->send(new revMail($query->first()->bons_id, $query->first()->name));
                return redirect()->route('bon.index');
            }
        }
        return redirect()->route('bon.index');
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

    public function  loadSales(Request $request)
    {
        $data = User::where("name", "LIKE", "%$request->q%")
            ->where("departement_id", '=', Auth::user()->departement_id)
            ->get(["id", "name"]);
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

    public function accAdmin($id)
    {
        $data = Acc::where('bons_id', $id)
            ->where('users_id', Auth::user()->id)
            ->first();
        $data->status = 'Terima';
        $data->save();

        $bon = Bon::find($id);

        $datas = DB::table("acc_access")
            ->where([
                ["departId", Auth::user()->departement_id],
                ["idPengaju", Auth::user()->id]
            ])->get();
        for ($i = 0; $i < count($datas); $i++) {
            $newBon = new Acc;
            $newBon->bons_id = $bon->id;
            $newBon->users_id = $datas[$i]->idAcc;
            $newBon->status = "Diproses";
            $newBon->level = $datas[$i]->level;
            $newBon->threshold = $datas[$i]->threshold;
            $newBon->save();
            if ($bon->total < $datas[$i]->threshold) break;
        }
        $query = DB::table('accs as a')
            ->join('users as u', 'a.users_id', '=', 'u.id')
            ->select('a.bons_id', 'u.id', 'u.name', 'a.level', 'u.email')
            ->where('bons_id', $id)
            ->where('level', 1)
            ->get();
        if ($query->first()) {
            Mail::to($query->first()->email)->send(new Email($query->first()->bons_id, $query->first()->name));
            return redirect()->route('bon.index')->with('status', 'Bon telah di terima');
        } else {
            return redirect()->route('bon.index')->with('status', 'Bon telah di terima');
        }
    }

    public function accBontThres($id)
    {
        $data = Acc::where('bons_id', $id)
            ->where('users_id', Auth::user()->id)
            ->first();
        $data->status = 'Terima';
        $data->keteranganAcc = 'Menyetujui bon sementara diluar threshold';
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
        $data->threshold = 0;
        $data->save();

        $bon = Bon::find($id);
        $bon->status = "Terima";
        $bon->save();
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
        $data->threshold = 0;
        $data->save();
        $bon = Bon::find($id);
        $bon->status = "Tolak";
        $bon->save();
        return redirect()->route('bon.index')->with('status', 'Bon telah di tolak');
    }
    public function FmRevBon(Request $request, $id)
    {
        $data = new Acc;
        $data->bons_id = $id;
        $data->users_id = Auth::user()->id;
        $confirmationInput = $request->get('revisi');
        $data->status = 'Revisi';
        $data->keteranganRevisi = $confirmationInput;
        $data->level = 6;
        $data->threshold = 0;
        $data->save();
        return redirect()->route('bon.index')->with('status', 'Bon telah diajukan untuk revisi');
    }
    public function fmIndex()
    {
        // $acc = DB::table('accs')
        //     ->join('bons', 'bons.id', '=', 'accs.bons_id')
        //     ->join('users as acc', 'acc.id', '=', 'accs.users_id')
        //     ->join('users as aju', 'aju.id', '=', 'bons.users_id')
        //     ->select('accs.bons_id', 'accs.status', 'acc.departement_id as dname', 'acc.jabatan_id as jabatan')
        //     ->get();
        // $x = [];
        // foreach ($acc as $item) {
        //     if ($item->status != 'Terima' || $item->jabatan == 3 && $item->dname == 8) {
        //         array_push($x, $item->bons_id);
        //     }
        // }
        // $data = DB::table('bons')
        //     ->join('users', 'bons.users_id', '=', 'users.id')
        //     ->join('departements', 'users.departement_id', '=', 'departements.id')
        //     ->join('accs', 'bons.id', '=', 'accs.bons_id')
        //     ->whereNotIn('bons.id', $x)->distinct()
        //     ->get([
        //         'bons.id', 'bons.tglPengajuan', 'bons.users_id', 'bons.total',
        //         'users.name as pengaju',
        //         'departements.name as dname'
        //     ]);
        // return response()->json([
        //     'data' => $data
        // ]);
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
            ->where([["u.jabatan_id", 8], ["u.departement_id", 9], ["a.status", "Terima"]])
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
    public function loadKasir()
    {
        // 3=Manager, 8=Finance
        // $data = DB::table("accs AS a")
        //     ->join("users AS u", "u.id", "=", "a.users_id")
        //     ->join("jabatans AS j", "j.id", "=", "u.jabatan_id")
        //     ->join("departements AS d", "d.id", "=", "u.departement_id")
        //     ->join("bons AS b", "b.id", "a.bons_id")
        //     ->joinSub(function ($q) {
        //         $q->select('users.id', 'users.name as uname', 'departements.name as dname')
        //             ->from("users")
        //             ->join('departements', 'users.departement_id', '=', 'departements.id');
        //     }, "aju", function ($join) {
        //         $join->on("aju.id", "=", "b.users_id");
        //     })
        //     ->where([["u.jabatan_id", 3], ["u.departement_id", 8], ["a.status", "Terima"]])
        //     ->whereNotIn('a.bons_id', function ($subquery) {
        //         $subquery->select('bons_id')
        //             ->from('accs')
        //             ->join('users', 'users.id', '=', 'accs.users_id')
        //             ->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
        //             ->where('users.jabatan_id', '=', Auth::user()->jabatan_id);
        //     })
        //     ->get(['aju.uname', 'aju.dname', 'b.tglPengajuan', 'b.total', 'u.name as ACC', 'b.status', 'b.id']);
        // return response()->json($data);
        $acc = DB::table('accs')
            ->join('bons', 'bons.id', '=', 'accs.bons_id')
            ->join('users as acc', 'acc.id', '=', 'accs.users_id')
            ->join('users as aju', 'aju.id', '=', 'bons.users_id')
            ->select('accs.bons_id', 'accs.status', 'acc.departement_id as dname', 'acc.jabatan_id as jabatan')
            ->get();
        $x = [];
        foreach ($acc as $item) {
            if ($item->status != 'Terima' || $item->jabatan == 8 && $item->dname == 9) {
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
                'detailbons.tglMulai', 'detailbons.tglAkhir', 'detailbons.asalKota', 'detailbons.tujuan', 'detailbons.agenda', 'detailbons.biaya', 'detailbons.projects_id', 'detailbons.penggunaan', 'detailbons.noPaket', 'detailbons.deleted_at',
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
            ->select('acc.name as acc_name', 'acc.jabatan_id as acc_jabatan', 'acc.departement_id as acc_depart', 'accs.status', 'accs.keteranganTolak', 'accs.keteranganAcc', 'accs.updated_at')
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
        $data->threshold = 0;
        $data->save();
        return redirect()->route('bon.index')->with('status', 'Bon telah di terima');
    }

    public function addNewDetail(Request $request)
    {
        $new = new DetailBon();
        $new->bons_id = $request->get("bid");
        $new->tglMulai = $this->convertDTPtoDatabaseDT($request->get("tglMulai"));
        $new->tglAkhir = $this->convertDTPtoDatabaseDT($request->get("tglAkhir"));
        $new->asalKota = $request->get("asalKota");
        $new->tujuan = $request->get("tujuan");
        $new->projects_id = ($request->get("select-ppc")) ? $request->get("select-ppc") : null;
        $new->users_id = $request->get("select-sales");
        $new->noPaket = ($request->get("noPaket")) ? $request->get("noPaket") : null;
        $new->agenda = $request->get("agenda");
        $new->penggunaan  = $request->get("keterangan");
        $new->biaya = $request->get("biaya");
        $new->save();

        $bon = Bon::find($request->get("bid"));
        $bon->total = $bon->total + $request->get("biaya");
        $bon->save();
        return response()->json(["status" => "ok", "id" => $new->id]);
    }
    public function addNewDetailRevision(Request $request)
    {
        $oriDetailAff = DetailBon::withTrashed()->find($request->get("id"))->delete();
        $others = DetailBon::withTrashed()->where("detailbons_revision_id", $request->get("id"))->delete();
        $new = new DetailBon();
        $new->bons_id = $request->get("bid");
        $new->tglMulai = $this->convertDTPtoDatabaseDT($request->get("tglMulai"));
        $new->tglAkhir = $this->convertDTPtoDatabaseDT($request->get("tglAkhir"));
        $new->asalKota = $request->get("asalKota");
        $new->tujuan = $request->get("tujuan");
        $new->projects_id = ($request->get("select-ppc")) ? $request->get("select-ppc") : null;
        $new->users_id = $request->get("select-sales");
        $new->noPaket = ($request->get("noPaket")) ? $request->get("noPaket") : null;
        $new->agenda = $request->get("agenda");
        $new->penggunaan  = $request->get("keterangan");
        $new->biaya = $request->get("biaya");
        $new->detailbons_revision_id = $request->get("id");
        $new->save();
        $bon = Bon::find($request->get("bid"));
        $bon->total = $bon->total + $request->get("biaya") - $request->get("biayaDeduct");
        $bon->save();
        return response()->json(["status" => "ok"]);
    }

    public function destroyDetail(Request $req)
    {
        $bon = Bon::find($req->get("bid"));
        $bon->total = $bon->total - $req->get("biaya");
        $bon->save();
        $aff = DetailBon::withTrashed()->find($req->get("id"))->delete();
        DetailBon::withTrashed()->where("detailbons_revision_id", $req->get("id"))->delete();
        return response()->json(["status" => $aff]);
    }
    public function decKasir(Request $request, $id)
    {
        $data = new Acc;
        $data->bons_id = $id;
        $data->users_id = Auth::user()->id;
        $confirmationInput = $request->get('tolak');
        $data->status = 'Tolak';
        $data->keteranganTolak = $confirmationInput;
        $data->level = 7;
        $data->threshold = 0;
        $data->save();
        $bon = Bon::find($id);
        $bon->status = "Tolak";
        $bon->save();
        return redirect()->route('bon.index')->with('status', 'Bon telah di tolak');
    }
    public function revKasir(Request $request, $id)
    {
        $data = new Acc;
        $data->bons_id = $id;
        $data->users_id = Auth::user()->id;
        $confirmationInput = $request->get('revisi');
        $data->status = 'Revisi';
        $data->keteranganRevisi = $confirmationInput;
        $data->level = 7;
        $data->threshold = 0;
        $data->save();
        return redirect()->route('bon.index')->with('status', 'Bon telah diajukan untuk revisi');
    }
    public function test4()
    {
    }
}
