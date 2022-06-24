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
    protected $package;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\Packages
     * @return void
     */
    public function __construct(Packages $package)
    {
        $this->package = $package;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('koliandco@gmail.com', 'Koli&co')
            ->subject('Requête envoyée au coursier')
            ->tag('request')
            ->view('emails.request.sent')
            ->with([
                'item' => $this->package->item,
                'category' => $this->package->category,
                'weight' => $this->package->weight,
                'departure' => $this->package->departure,
                'destination' => $this->package->destination,
                'prix' => $this->package->prix,
            ]);
    }
}
