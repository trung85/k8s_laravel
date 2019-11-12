<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Jobs\SendOrderEmail;
use App\Mail\OrderShipped;
use App\Order;
use Log;

class MailController extends Controller
{
    public function index() {

        $order = Order::findOrFail( rand(1,50) );

        $recipient = 'steven@example.com';

        Mail::to($recipient)->send(new OrderShipped($order));

        return 'Sent order ' . $order->id;
    }

    public function testQueue() {

        $order = Order::findOrFail( rand(1,50) );
        SendOrderEmail::dispatch($order);

        Log::info('Dispatched order ' . $order->id);
        return 'Dispatched order ' . $order->id;
    }
}
