<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LgtExpiration extends Mailable
{
    use Queueable, SerializesModels;

    public $viste_techniques = [] ;
    public $extincteurs = [] ;
    public $vidanges = [] ;
    public $sujet = "" ;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Array $viste_techniques, Array $extincteurs, Array $vidanges, $sujet )
    {
        $this->viste_techniques = $viste_techniques;
        $this->extincteurs = $extincteurs;
        $this->vidanges = $vidanges;
        $this->sujet = $sujet;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config("app.EMAIL_GEDES")) // L'expéditeur
                    ->subject($this->sujet) // Le sujet
                    ->view('email.lgtexpiration'); // La vue
    }
}
