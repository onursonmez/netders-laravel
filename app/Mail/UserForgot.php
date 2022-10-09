<?php

namespace App\Mail;

use App\Models\Password_request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserForgot extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $password_request;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Password_request $password_request)
    {
        $this->password_request = $password_request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->password_request->user->first_name.', şifre değiştirme talebin')->markdown('emails.users.forgot');
    }
}
