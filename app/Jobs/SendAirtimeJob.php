<?php

namespace App\Jobs;

use App\Events\AirtimeSentEvent;
use App\Exceptions\AfricasTalkingGatewayException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendAirtimeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $phone;

     public $amount;

    public $gateway;

    public function __construct($phone, $amount)
    {
        $this->gateway = app('africas');
        $this->phone = $phone;
        $this->amount = $amount;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $recipients = array(array("phoneNumber"=>"{$this->phone}", "amount"=>"KES {$this->amount}"));

        Log::info($recipients);
        try {
            $results = $this->gateway->sendAirtime(json_encode($recipients));
            Log::info($results);

            AirtimeSentEvent::dispatch($this->phone);

        } catch (AfricasTalkingGatewayException $e) {
            Log::critical($e->getMessage());
        }
    }
}
