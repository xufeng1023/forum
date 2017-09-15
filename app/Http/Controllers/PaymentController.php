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
    	//$user = User::findOrFail(3);
    	$user = User::first();

    	try {
    		$stripeToken = $this->token();
    		$user->newSubscription('main', 'main')
				->trialDays(7)
				->create($stripeToken->id);
    	} catch(\Exception $e) {
    		exit($e->getMessage());
    	}
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
