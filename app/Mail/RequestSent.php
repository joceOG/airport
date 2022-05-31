<?php

namespace App\Mail;

use App\Models\Packages;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestSent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     *
     *
     *
     */
    public $package;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\Packages
     * @return void
     */
    public function __construct(Packages $package)
    {
        $this->package =$package;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('koliandco@gmail.com', 'Koli&co')
            ->subject('Requête envoyée au vendeur')
            ->tag('request')
            ->metadata('package_id', $this->package->package_id)
            ->view('emails.request.sent');
    }
}
