<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SimpleEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $to_, $message_, $sujet_;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sujet, $message)
    {
        $this->message_ = $message;
        $this->sujet_ = $sujet;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.simple_email')
                    ->from(config("app.EMAIL_GEDES")) // L'expéditeur
                    ->subject($this->sujet_) ;
    }
}
