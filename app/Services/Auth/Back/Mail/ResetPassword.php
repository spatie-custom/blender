<?php

namespace App\Services\Auth\Back\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Services\Auth\Back\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPassword extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /** @var \App\Services\Auth\Back\User */
    public $user;

    /** @var string */
    public $token;

    /**
     * Create a new message instance.
     *
     * @param \App\Services\Auth\Back\User $user
     * @param string                       $token
     */
    public function __construct(User $user, string $token)
    {
        $this->user = $user;

        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('🔐 Toegang tot '.config('app.url'))
            ->markdown($this->user->hasNeverLoggedIn() ? 'mails.admin.setPassword' : 'mails.admin.resetPassword');
    }
}
