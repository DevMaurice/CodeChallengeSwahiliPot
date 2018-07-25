<?php

namespace App\Jobs;

use App\Exceptions\AfricasTalkingGatewayException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MpesaCheckoutJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $phone;

    public $gateway;

    public function __construct($phone)
    {
        $this->gateway = app('africas');
        $this->phone = $phone;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $productName  = "SampleSafiree";
        $currencyCode = "KES";
        // The checkout amount
        $amount = 100.50;

        $metadata = array(
                "productId" => "321",
                "description" => "Swahili Challenge"
                  );
        try {
            $transactionId = $this->gateway->initiateMobilePaymentCheckout(
                                $productName,
                               $this->phone,
                               $currencyCode,
                               $amount,
                               $metadata
            );
        } catch (AfricasTalkingGatewayException $e) {
            Log::critical("Received error response: ".$e->getMessage());
        }
    }
}
