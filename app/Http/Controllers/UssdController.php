<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UssdController extends Controller
{
    public function handle()
    {

    switch (request('text')) {
        case '':
                $response  = "CON What would you want Kindly choose from below. \n";
                $response .= "1. Mobile checkout \n";
                $response .= "2. Send airtime";
            break;
        case '1':
                $response  = "END Enter your Mpesa pin on next Screen. \n";

            break;
        case '2':
                $response  = "CON How much do you want to send \n";
            break;

        case '2*1':
                $response  = "CON How much do you want to send \n";
            break;

        default:
            $response  = "END  Unrecognized selection \n";
            break;
    }

    Log::info(request()->all());

    return $response;
    }
}
