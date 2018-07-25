<?php

namespace App\Listeners;

use App\Events\AirtimeSentEvent;
use App\Exceptions\AfricasTalkingGatewayException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendConfirmationMessage
{
    public $gateway;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
         $this->gateway = app('africas');
    }

    /**
     * Handle the event.
     *
     * @param  AirtimeSentEvent  $event
     * @return void
     */
    public function handle(AirtimeSentEvent $event)
    {
        $message = "You have received KES 20 worth of airtime from DevMurice.";
        try
            {
              $results = $this->gateway->sendMessage($event->phone, $message);
            }
            catch ( AfricasTalkingGatewayException $e )
            {
              Log::critical("Encountered an error while sending sms: ".$e->getMessage());
            }
    }
}
