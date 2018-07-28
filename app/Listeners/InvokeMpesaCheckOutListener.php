<?php

namespace App\Listeners;

use App\Events\MpesaCheckoutEvent;
use App\Jobs\MpesaCheckoutJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class InvokeMpesaCheckOutListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MpesaCheckoutEvent  $event
     * @return void
     */
    public function handle(MpesaCheckoutEvent $event)
    {
        MpesaCheckoutJob::dispatch($event->phone)->delay(now()->addSeconds(5));
    }
}
