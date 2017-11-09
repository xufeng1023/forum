<?php

namespace App\Http\Controllers;

use App\{User, Mail\ThankYouPayment};
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController
{
    public function handleChargeSucceeded(array $payload)
    {
        $user = $this->getUserByStripeId($payload['data']['object']['customer']);
if(!$user) $user = User::first();
        if($user) {
			\Mail::to($user)->send(
				new ThankYouPayment(
					sprintf("%01.2f", $payload['data']['object']['amount'] / 100)
				)
			);
        }
        
        return response('Charge success Handled!', 200);
    }
}
