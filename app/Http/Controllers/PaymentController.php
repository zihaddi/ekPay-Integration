<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function initiatePayment(Request $request)
    {

        // Store values in variables
        $merRegId = "rdcd_test";
        $merPasKey = "RuraLdcd@tsT10";
        $reqTimestamp = Carbon::now('Asia/Dhaka')->format('Y-m-d H:i:s') . ' GMT+6';

        $custId = "payerID02";
        $custName = "Mr. Payer";
        $custMoboNo = "+8801721356988";
        $custEmail = "payer@gmail.com";
        $custMailAddr = "361/a,dhanmondi,dhaka-1207";
        $trnxId = "00353";
        $sUri = "http://127.0.0.1:8002/success/payment";
        $fUri = "http://www.marhent.com/decline/payment";
        $cUri = "http://www.marchent.com/cancel/payment" ;
        $trnxAmt = "8000";
        $trnxCurrency = "BDT";
        $ordId = "00137";
        $ordDet = "Desco Bill:00125, DPDC Bill:12546. Month jun-18"  ;
        $ipnChannel = "3";
        $ipnEmail ="zihad.jamil2018@gmail.com";
        $ipnUri = "http://127.0.0.1:8002/v1/payment/ipn";
        // $ipnUri = "https://www.marchent.com/yourIpnListeneripn@marchent.com";
        $macAddr ="1.1.1.1";

        // Build the request payload
        $phpArray = [
            'mer_info' => [
                'mer_reg_id' => $merRegId,
                'mer_pas_key' => $merPasKey,
            ],
            'req_timestamp' => $reqTimestamp,
            'feed_uri' => [
                's_uri' => $sUri,
                'f_uri' => $fUri,
                'c_uri' => $cUri,
            ],
            'cust_info' => [
                'cust_id' => $custId,
                'cust_name' => $custName,
                'cust_mobo_no' => $custMoboNo,
                'cust_email' => $custEmail,
                'cust_mail_addr' => $custMailAddr,
            ],
            'trns_info' => [
                'trnx_id' => $trnxId,
                'trnx_amt' => $trnxAmt,
                'trnx_currency' => $trnxCurrency,
                'ord_id' => $ordId,
                'ord_det' => $ordDet,
            ],
            'ipn_info' => [
                'ipn_channel' => $ipnChannel,
                'ipn_email' => $ipnEmail,
                'ipn_uri' => $ipnUri,
            ],
            'mac_addr' => $macAddr,
        ];

        // Send the request to the ekPay Payment Gateway API
        $response = Http::post('https://sandbox.ekpay.gov.bd/ekpaypg/v1/merchant-api', $phpArray);

        // dd(json_decode($response));

        $token = json_decode($response)->secure_token ;

        // Process the response and retrieve the secure token and other details

        // Redirect the user to the ekPay Payment Gateway page with the secure token and transaction ID
        return redirect()->away("https://sandbox.ekpay.gov.bd/ekpaypg/v1?sToken={$token}&trnsID={$trnxId}");
    }




    public function handleIPN(Request $request)
    {


        logger('hiiiiiiii');
        // Extract the IPN parameters from the request
        $secureToken = $request->input('secure_token');
        $msgCode = $request->input('msg_code');
        $msgDet = $request->input('msg_det');
        // Extract other IPN parameters

        // Process the IPN and perform necessary actions

        // Send an acknowledgment response back to the Payment Gateway
        return response()->json([
            'ack_code' => 'ack001',
            'ack_msg' => 'Acknowledge Successfully.',
            'ack_timestamp' => now()->toIso8601String(),
        ]);
    }



    public function successReq()
    {
        dd('hii');
        return "Done Successfully";
    }
}
