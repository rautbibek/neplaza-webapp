<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyMail extends Mailable
{
    use Queueable, SerializesModels;
    public $activation_code;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($activation_code)
    {
        $this->activation_code = $activation_code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $code = $this->activation_code;
        return $this->view('email.verify',compact('code'));
    }
}
