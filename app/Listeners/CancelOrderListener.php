<?php

namespace App\Listeners;

use App\Events\CancelOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CancelOrderListener
{
    
    /**
     * Handle the event.
     *
     * @param  CancelOrder  $event
     * @return void
     */
    public function handle(CancelOrder $event)
    {
        $message = $event->request->user()->name . ', CancelOrder in to the application.';
        \Storage::put('event/CancelOrder.txt', $message);
    }
}
