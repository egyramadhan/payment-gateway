<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Veritrans;
use Veritrans_Snap;
use Veritrans_Notification;
use Redirect;
// use App\Veritrans\Veritrans;

class PaymentController extends Controller
{
   

    public function __construct(Request $request)
    {
        $this->request = $request;
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-Gxr1vP8AGzCQPK7Rfs0o9W2D';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

    }

    public function index()
    {
        // $url = 'https://app.sandbox.midtrans.com/snap/v1/transactions';
        // $authorization = "Basic Auth";
        // $server_key = 'SB-Mid-server-Gxr1vP8AGzCQPK7Rfs0o9W2D';
        // $accept_type = 'application/json';
        // $client = new Client();
        
        // $respone = $client->request('post', $url,[
        //     'headers' => [
        //         'Accept' => $accept_type,
        //         'Content-Type' => $accept_type,
        //         // 'Authorization' => 'Basic ' . $server_key,
        //     ],
        // ]);

        // $data = json_decode($respone->getBody()->getContents());
        //     dd($data);
        // $params = array(
        //     'transaction_details' => array(
        //         'order_id' => 'Jouska-'. rand(1000,10000),
        //         'gross_amount' => 10000,
        //     )
        // );

        // return $params;
        $payload = [
            'transaction_details' => [
                'order_id'      => 1234,
                'gross_amount'  => 10000,
            ],
            'customer_details' => [
                'first_name'    => 'tes aa',
                'email'         => 'e@e.com',
                // 'phone'         => '08888888888',
                // 'address'       => '',
            ]
        ];
        $snapToken = \Midtrans\Snap::getSnapToken($payload);
        
        // $donation->save();

        // Beri response snap token
        // $this->response['snap_token'] = $snapToken;
        try {
            // Get Snap Payment Page URL
            $paymentUrl = \Midtrans\Snap::createTransaction($payload)->redirect_url;
            
            // Redirect to Snap Payment Page
            header('Location: ' . $paymentUrl);
          }
          catch (Exception $e) {
            echo $e->getMessage();
          }
        //   dd($paymentUrl);
        // return response()->json($this->response);

        // dd($paymentUrl);

        return Redirect::to($paymentUrl);
        // return $paymentUrl;
    }

    public function testing(){

    }
}


