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
    	if($user->api_token != $request->apiToken) {
            return response([], 401);
        }

    	try {
    		$stripeToken = $this->token();
    		$user->newSubscription('main', 'main')
				->trialDays(7)
				->create($stripeToken->id);
    	} catch(\Exception $e) {
    		exit($e->getMessage());
    	}

        return response(['You are now a subscriber.'], 200);
    }

    public function upgrade()
    {
    	$user = User::first();

		$user->subscription('main')->swap('second');
    }

    public function cancel()
    {	// todo: when user cancels, hide card info remove.
    	$user = User::first();
    	$user->subscription('main')->cancel();
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
