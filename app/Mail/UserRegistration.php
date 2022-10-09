<?php

namespace App\Mail;

use App\Models\Email_request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistration extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $email_request;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Email_request $email_request)
    {
        $this->email_request = $email_request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->email_request->user->first_name.', hoş geldin 😊👏❤️')->markdown('emails.users.registration');
    }
}
