<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order; // ضروري نزيدو هادي

class OrderConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $commande; // عرفنا المتغير هنا باش يتشاف فـ الـ View

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order) // هنا كايستقبل الطلبية من الـ Controller
    {
        $this->commande = $order;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->markdown('emails.orders.confirmed')
            ->subject('Confirmation de votre commande - Parapharmacie');
    }
}
