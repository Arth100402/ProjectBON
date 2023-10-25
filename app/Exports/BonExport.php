<?php

namespace App\Exports;

use App\Models\Bon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\contracts\view\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use NumberFormatter;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class BonExport implements FromCollection, WithHeadings
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
        $this->pengaju = $pengaju == "null" ? null : $pengaju;
        $this->opti = $opti == "null" ? null : $opti;
        $this->status = $status;
    }
    public function headings(): array
    {
        return [
            ['Tanggal Mulai', 'Pengaju', 'ID Opti', "Total", "Status"],
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $q = Bon::join('users', "bons.users_id", "users.id")
            ->join('detailbons', "detailbons.bons_id", "bons.id")
            ->join('projects', "detailbons.projects_id", "projects.id")
            ->whereBetween('bons.tglPengajuan', [$this->tglMulai, $this->tglAkhir])
            ->where([
                ["bons.users_id", "LIKE", $this->pengaju],
                ["detailbons.projects_id", "LIKE", $this->opti],
                ["users.departement_id", Auth::user()->departement_id]
            ])->orderBy('bons.tglPengajuan');
        switch ($this->status) {
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
        $totalSum = $q->sum('bons.total');
        $data[] = ['tglPengajuan' => ' ', 'name' => 'Total', 'idOpti' => ' ', 'total' => $totalSum, 'status' => ' '];

        return $data;
    }

    private function formatPrice($price)
    {
        return (new NumberFormatter("id_ID", NumberFormatter::CURRENCY))->formatCurrency($price, "IDR");
    }
}
