<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ThankYouPayment extends Mailable
{
    use Queueable, SerializesModels;

    public $price;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($price)
    {
        $this->price = $price;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.paysuccess');
    }
}
