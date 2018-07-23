<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Exceptions\AfricasTalkingGatewayException;

class UssdController extends Controller
{
    public $gateway;

    public function __construct()
    {
        $this->gateway = app('africas');
    }
    public function index()
    {
        dd($this->gateway);
    }

    public function handle()
    {
        Log::info(request()->all());
        
        $sel = explode('*', request('text'));
        Log::info($sel);
        switch ($sel[0]) {
            case '':
                    $response  = "CON What would you want Kindly choose from below. \n";
                    $response .= "1. Mobile checkout \n";
                    $response .= "2. Send airtime";
                break;
            case '1':
                    $response  = "END Enter your Mpesa pin on next Screen. \n";
                    $this->checkout(request('phoneNumber'));

                break;
            case '2':
                $response = "CON How much do you want to send \n";

                if (count($sel) > 1) {
                    $response  = "END Thank you \n";
                    $this->sendAirtime(request('phoneNumber'), $sel[1]);
                }
                break;

            default:
                $response  = "END  Unrecognized selection \n";
                break;
        }

        return $response;
    }

    public function checkout($phoneNumber)
    {
        $metadata = [
            'id' => '32174763',
            'name' => 'My product',
        ];
        try {
            // Initiate the checkout. If successful, you will get back a transactionId
            $transactionId = $this->gateway->initiateMobilePaymentCheckout(
                                        'SampleSafiree',
                                         $phoneNumber,
                                         'KES',
                                         10.0,
                                         $metadata
            );
            Log::info("The id here is ".$transactionId);
        } catch (AfricasTalkingGatewayException $e) {
            Log::warning("Received error response: ".$e->getMessage());
        }
    }

    public function sendAirtime($phone, $amount)
    {
        $data = array(
            array('phonenumber' => $phone,'amount' => 'KES '.$amount)
        );

        $numbers = json_encode($data);
        
        try {
            $results = $this->gateway->sendAirtime($numbers);
            Log::warning($results);
        } catch (AfricasTalkingGatewayException $e) {
            Log::warning($e->getMessage());
        }
    }

    public function sendMessage()
    {
        //vvvvv
    }
}
