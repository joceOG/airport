<?php

namespace App\Mail;

use App\Models\Orders;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeliveryConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     *
     *
     *
     */
    protected $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Orders $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('koliandco@gmail.com', 'Koli&co')
            ->subject('Confirmation de livraison')
            ->tag('confirmation')
            ->view('emails.confirmation')
            ->with([
                'status' => $this->order->status,
                'order_id' => $this->order->order_id,
            ]);
    }
}
