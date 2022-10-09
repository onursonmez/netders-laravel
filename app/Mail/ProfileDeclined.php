<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProfileDeclined extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user, $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $message = null)
    {
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->user->first_name.', profilin onaylanmadı 😞')->markdown('emails.users.profile_declined');
    }
}
