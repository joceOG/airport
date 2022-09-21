<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Ramsey\Uuid\Rfc4122\UuidV4;

class AccountCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     *
     *
     *
     */
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->view('emails.account');
        $this->from('koliandco@gmail.com', 'Koli&co');
        $this->subject('Bienvenue chez Koli&co!');
        $this->with([
            'user_id' => $this->user->user_id,
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name
        ]);

        return $this;
    }
}
