<?php

namespace App\Http\Controllers;

use App\User;
use Stripe\{Stripe,Token};
use Illuminate\Http\Request;

class PaymentController extends Controller
{
	public function __construct()
	{
		Stripe::setApiKey(config('services.stripe.secret'));
	}

    public function subscribe(Request $request, User $user)
    {
    	$user = User::first();

    	$stripeToken = $this->token();

		$user->newSubscription('main', 'main')
		->trialDays(10)
		->create($stripeToken->id);
    }

    private function token()
	{
		return Token::create([
			  	"card" => [
			    "number" => "4000000000000077",
			    "exp_month" => 9,
			    "exp_year" => 2018,
			    "cvc" => "314"
		  	]
		]);
	}
}
