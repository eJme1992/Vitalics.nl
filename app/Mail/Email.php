<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $uempresa;
    public $password;

    public function __construct($user, $uempresa, $password)
    {
 
         $this->user = $user;
         $this->uempresa = $uempresa;
         $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('mail.email')
                    ->from('support@fullyshops.com')
                    ->subject('¡Has Registrado Un Usuario!');
    }
}
