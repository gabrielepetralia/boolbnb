<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Braintree\Gateway;
use App\Models\Sponsorship;

class OrderController extends Controller
{
  public function generate(Request $request, Gateway $gateway)
  {

    $token = $gateway->clientToken()->generate();

      return response()->json(compact('token'));
  }


  public function makePayment(Request $request, Gateway $gateway)
{

    $sponsorship = Sponsorship::find($request->sponsorshipId);

    $result = $gateway->transaction()->sale([
        'amount' => $sponsorship->price,
        'paymentMethodNonce' => 'fake-valid-nonce',
        'options' => [
            'submitForSettlement' => true
         ]
        ]);

    if($result->success){
       $data = [
           'success' => true,
            'message' => "Transazione eseguita con successo"
       ];


      return response()->json($data, 200);
    }else {
        $data = [
            'success' => false,
            'message' => "Transazione fallita"
        ];


        return response()->json($result, 401);
    }
}
}
