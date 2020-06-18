<?php

namespace App\Listeners;

use App\Events\PlaceOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PlaceOrderListener
{

    /**
     * Handle the event.
     *
     * @param  PlaceOrder  $event
     * @return void
     */
    public function handle(PlaceOrder $event)
    {
        $message = $event->request->user()->name . ', OrderPalced in to the application.';
        \Storage::put('event/PlaceOrder.txt', $message);
    }
}
