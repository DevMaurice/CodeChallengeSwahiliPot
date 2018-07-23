<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Exceptions\AfricasTalkingGatewayException;

class MpesaController extends Controller
{
    public $gateway;

    public function __construct()
    {
        $this->gateway = app('africas');
    }

    public function index()
    {
        
// Specify the name of your Africa's Talking payment product
        $productName  = "SampleSafiree";
        // The phone number of the customer checking out
        $phoneNumber  = "+254714692255";
        // The 3-Letter ISO currency code for the checkout amount
        $currencyCode = "KES";
        // The checkout amount
        $amount       = 100.50;
        // Any metadata that you would like to send along with this request
        // This metadata will be  included when we send back the final payment notification
        $metadata     = array("agentId"   => "654",
                      "productId" => "321");
        try {
            // Initiate the checkout. If successful, you will get back a transactionId
            $transactionId = $this->gateway->initiateMobilePaymentCheckout(
                                $productName,
                               $phoneNumber,
                               $currencyCode,
                               $amount,
                               $metadata
            );
            dd("The id here is ".$transactionId);
        } catch (AfricasTalkingGatewayException $e) {
            dd("Received error response: ".$e->getMessage());
        }
    }

    public function handle()
    {
        Log::info(request()->all());
    }
}
