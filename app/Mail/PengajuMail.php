<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class PengajuMail extends Mailable
{
    use Queueable, SerializesModels;

    private $bons_id;
    private $name;
    private $results;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($bons_id, $name)
    {
        $this->bons_id = $bons_id;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $result = DB::table('detailbons as db')
            ->select('db.*', 'u.id', 'u.name', 'p.id', 'p.idOpti')
            ->leftJoin('projects as p', 'db.projects_id', '=', 'p.id')
            ->join('users as u', 'db.users_id', '=', 'u.id')
            ->where('db.bons_id', $this->bons_id)
            ->get();
        return $this->view('mail.pengaju')
                    ->with(['bons_id' => $this->bons_id,
                            'name' => $this->name,
                            'results' => $result])
                    ->subject('Revisi Bon Sementara');
    }
}
