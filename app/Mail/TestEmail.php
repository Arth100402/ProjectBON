<?php

namespace App\Mail;

use App\Models\Vehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $send;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($send)
    {
        $this->send = $send[0];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.test')->subject('Reminder Pajak');
    }
}
