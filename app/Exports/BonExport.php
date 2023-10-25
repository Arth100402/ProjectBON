<?php

namespace App\Exports;

use App\Models\Bon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use NumberFormatter;

class BonExport implements FromCollection
{
    use Exportable;

    private $tglMulai;
    private $tglAkhir;
    private $pengaju;
    private $opti;
    private $status;
    public function __construct($tglMulai, $tglAkhir, $pengaju, $opti, $status)
    {
        $this->tglMulai = $tglMulai;
        $this->tglAkhir = $tglAkhir;
        $this->pengaju = $pengaju;
        $this->opti = $opti;
        $this->status = $status;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // $q = Bon::join('users', "bons.users_id", "users.id")
        //     ->join('detailbons', "detailbons.bons_id", "bons.id")
        //     ->join('projects', "detailbons.projects_id", "projects.id")
        //     ->whereBetween('bons.tglPengajuan', [$this->tglMulai, $this->tglAkhir])
        //     ->where([
        //         ["bons.users_id", "LIKE", $this->pengaju],
        //         ["detailbons.projects_id", "LIKE", $this->opti],
        //         ["users.departement_id", Auth::user()->departement_id]
        //     ])->orderBy('bons.tglPengajuan');
        // switch ($this->status) {
        //     case 'placeholder':
        //         $q->where(function ($query) {
        //             $query->whereIn("bons.status", ["Terima", "Tolak"])->orWhereNull("bons.status");
        //         });
        //         break;
        //     case 'Menunggu':
        //         $q->whereNull("bons.status");
        //         break;
        //     case 'Terima':
        //         $q->where("bons.status", "Terima");
        //         break;
        //     default:
        //         $q->where("bons.status",  "Tolak");
        //         break;
        // }
        // $data = $q->get(["bons.tglPengajuan", "users.name", "projects.idOpti", "bons.total", "bons.status"]);
        // $total = $this->formatPrice($data->sum('total'));

        return Bon::all();
    }

    private function formatPrice($price)
    {
        return (new NumberFormatter("id_ID", NumberFormatter::CURRENCY))->formatCurrency($price, "IDR");
    }
}
