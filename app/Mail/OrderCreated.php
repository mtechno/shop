<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCreated extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    protected $order;


    public function __construct($name, Order $order)
    {
        $this->name = $name;
        $this->order = $order;
    }


    public function build()
    {
        $fullSum = $this->order->calculateFullSum();
        return $this->view('mail.order_created', [
            'name' => $this->name,
            'fullSum' => $fullSum,
            'order' => $this->order
        ]);
    }
}
