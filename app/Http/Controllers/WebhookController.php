<?php

namespace App\Http\Controllers;

use App\{User, Mail\ThankYouPayment};
use Illuminate\Http\Request;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController
{
    public function handleInvoicePaymentSucceeded(Request $request)
    {
        $data = $request->all()['data']['object'];
        //$user = User::Where('stripe_id', $data['customer'])->first();
        $user = User::first();
        \Mail::to($user)->send(new ThankYouPayment);
    }
}
