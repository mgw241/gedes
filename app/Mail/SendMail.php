<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data ;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Array $mesdonnees)
    {
        $this->data = $mesdonnees;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('view.name');
        
        return $this->from(config("app.EMAIL_GEDES")) // L'expéditeur
                    ->subject($this->data['sujet']) // Le sujet
                    ->view('email.test'); // La vue
    }

    public function basicEmail($sujet, $to, $message){
        return $this->from(config("app.EMAIL_GEDES")) // L'expéditeur
                    ->subject($sujet) // Le sujet
                    ->new($message)
                    ;//->view('email.test'); // La vue
    }
}
