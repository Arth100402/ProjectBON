<?php

namespace App\Console\Commands;

use App\Mail\TestEmail;
use App\Mail\TestEmail2;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendSTNK extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:stnk {id}';

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
        $id = $this->argument('id');
        $ex = explode('=',$id);
        $send = DB::table('vehicles')->where('id',$ex[0])->get();
        Mail::to('salomonsalom111@gmail.com')->send(new TestEmail2($send));
    }
}
