<?php

namespace App\Mail;

use App\Models\Orders;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResponseSent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     *
     *
     *
     */
    public $order;
    public $status;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Orders $order, String $status)
    {
        $this->order = $order;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('koliandco@gmail.com', 'Koli&co')
            ->subject('Réponse du coursier')
            ->tag('response')
            ->metadata('order_id', $this->order->order_id)
            ->view('emails.response.sent');
    }
}
