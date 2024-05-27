<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecuperarPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $token;
    public $codigo;

    public function __construct($email, $token, $codigo)
    {
        $this->email = $email;
        $this->token = $token;
        $this->codigo = $codigo;
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject('Recuperar Contraseña')
                    ->view('emails.recuperar_password')
                    ->with([
                        'email' => $this->email,
                        'token' => $this->token,
                        'codigo' => $this->codigo,
                    ]);
    }
}
