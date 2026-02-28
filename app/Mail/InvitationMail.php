<?php

namespace App\Mail;

use App\Models\Colocation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Colocation $colocation,
        public string $token
    ) {
    }

    public function build()
    {
        return $this
            ->subject('Invitation à rejoindre une colocation')
            ->view('emails.invitation');
    }
}