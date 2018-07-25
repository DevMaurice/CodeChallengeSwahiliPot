<?php

namespace App\Http\Controllers;

use App\Exceptions\AfricasTalkingGatewayException;
use App\Jobs\MpesaCheckoutJob;
use App\Jobs\SendAirtimeJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
                    $response  = "END Thank you. \n";
                    MpesaCheckoutJob::dispatch(request('phoneNumber'));
                break;
            case '2':
                $response = "CON How much do you want to send \n";

                if (count($sel) > 1) {
                    $response  = "END Thank you \n";
                    SendAirtimeJob::dispatch(request('phoneNumber'), $sel[1]);
                }
                break;

            default:
                $response  = "END  Unrecognized selection \n";
                break;
        }
        return $response;
    }
}
