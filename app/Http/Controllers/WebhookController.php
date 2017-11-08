<?php

namespace App\Http\Controllers;

use App\{User, Mail\ThankYouPayment};
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController
{
    public function handleChargeSucceeded(array $request)
    {
        $data = $request['data']['object'];
        return 'ss';
        //$user = User::Where('stripe_id', $data['customer'])->first();
        $user = User::first();
        \Mail::to($user)->send(new ThankYouPayment);
    }
}
