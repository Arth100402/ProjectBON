<?php

namespace App\Http\Controllers;

use App\Models\Bon;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use NumberFormatter;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $earliest = Bon::orderBy('tglPengajuan', "ASC")->first();
        $latest = Bon::orderBy('tglPengajuan', "DESC")->first();
        $all = Bon::join('users', "bons.users_id", "users.id")
            ->join('detailbons', "detailbons.bons_id", "bons.id")
            ->join('projects', "detailbons.projects_id", "projects.id")
            ->where("users.departement_id", Auth::user()->departement_id)
            ->orderBy('bons.tglPengajuan')
            ->get(["bons.tglPengajuan", "users.name", "projects.idOpti", "bons.total", "bons.status"]);
        $total =  $this->formatPrice($all->sum("total"));
        $q = Bon::join('users', "bons.users_id", "users.id")
            ->join('detailbons', "detailbons.bons_id", "bons.id")
            ->join('projects', "detailbons.projects_id", "projects.id")
            ->select(DB::raw("DATE(bons.tglPengajuan) as date"), DB::raw("AVG(bons.total) as avg_total"))
            ->where([
                ["users.departement_id", Auth::user()->departement_id]
            ])
            ->groupBy(DB::raw("DATE(bons.tglPengajuan)"))
            ->orderBy('bons.tglPengajuan')
            ->get();
        dd($q);
        $chartData = [['Date', 'Total']];
        foreach ($q as $row) {
            $chartData[] = [$row->date, $row->avg_total];
        }
        return view('report', compact('earliest', 'latest', "all", "total", "chartData"));
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

    public function filterBons(Request $request)
    {
        $tglMulai = $this->convertDTPtoDatabaseDT($request->get("m"));
        $tglAkhir = $this->convertDTPtoDatabaseDT($request->get("a"));
        $pengaju = $request->get("p") ? `%` . $request->get("p") . `%` : "%%";
        $opti = $request->get("o") ?  `%` . $request->get("o") . `%`  : "%%";
        $q = Bon::join('users', "bons.users_id", "users.id")
            ->join('detailbons', "detailbons.bons_id", "bons.id")
            ->join('projects', "detailbons.projects_id", "projects.id")
            ->whereBetween('bons.tglPengajuan', [$tglMulai, $tglAkhir])
            ->where([
                ["bons.users_id", "LIKE", $pengaju],
                ["detailbons.projects_id", "LIKE", $opti],
                ["users.departement_id", Auth::user()->departement_id]
            ])->orderBy('bons.tglPengajuan');
        switch ($request->get("s")) {
            case 'placeholder':
                $q->where(function ($query) {
                    $query->whereIn("bons.status", ["Terima", "Tolak"])->orWhereNull("bons.status");
                });
                break;
            case 'Menunggu':
                $q->whereNull("bons.status");
                break;
            case 'Terima':
                $q->where("bons.status", "Terima");
                break;
            default:
                $q->where("bons.status",  "Tolak");
                break;
        }
        $data = $q->get(["bons.tglPengajuan", "users.name", "projects.idOpti", "bons.total", "bons.status"]);
        $total = $this->formatPrice($data->sum('total'));
        return response()->json(compact('data', 'total'));
    }

    private function convertDTPtoDatabaseDT($date)
    {
        return date("Y-m-d", strtotime(str_replace(" ", "", explode(",", $date)[1])));
    }

    private function formatPrice($price)
    {
        return (new NumberFormatter("id_ID", NumberFormatter::CURRENCY))->formatCurrency($price, "IDR");
    }
}
