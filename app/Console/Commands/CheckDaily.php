<?php

namespace App\Console\Commands;

use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class CheckDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checkdaily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (Schema::hasTable('vehicles'))
        {
            $vehicle = Vehicle::all();
            foreach ($vehicle as $index => $row) {
                $now = now();
                $nowexplode = explode(' ', $now);
                $datetimenow = $nowexplode[0];
                
                $cronParts = explode(' ', $row->tanggalBayarPajakTahunan);
                $pajakMonth = Carbon::parse($cronParts[0])->subMonth(1)->format('Y-m-d');
                $pajaktwoweeks = Carbon::parse($cronParts[0])->subWeeks(2)->format('Y-m-d');
                $pajakoneweek = Carbon::parse($cronParts[0])->subWeek(1)->format('Y-m-d');

                if ($pajakMonth == $datetimenow)
                {
                    Artisan::call('command:pajak',['id' => $row->id]);
                }

                if ($pajaktwoweeks == $datetimenow)
                {
                    Artisan::call('command:pajak',['id' => $row->id]);
                }

                if ($pajakoneweek == $datetimenow)
                {
                    Artisan::call('command:pajak',['id' => $row->id]);
                }

                $cronParts2 = explode(' ', $row->masaBerlakuSTNK);
                $stnkMonth = Carbon::parse($cronParts2[0])->subMonth(1)->format('Y-m-d');
                $stnktwoweeks = Carbon::parse($cronParts2[0])->subWeeks(2)->format('Y-m-d');
                $stnkoneweek = Carbon::parse($cronParts2[0])->subWeek(1)->format('Y-m-d');

                if ($stnkMonth == $datetimenow)
                {
                    Artisan::call('command:stnk',['id' => $row->id]);
                }

                if ($stnktwoweeks == $datetimenow)
                {
                    Artisan::call('command:stnk',['id' => $row->id]);
                }

                if ($stnkoneweek == $datetimenow)
                {
                    Artisan::call('command:stnk',['id' => $row->id]);
                }
            }
        }
    }
}
