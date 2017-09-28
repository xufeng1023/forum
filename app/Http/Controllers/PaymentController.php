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
    	$this->checkToken($request, $user);

    	try {
    		$stripeToken = $this->token();
    		$user->newSubscription('main', 'monthly')
				->create($stripeToken->id);
    	} catch(\Exception $e) {
            return $e->getMessage();
    	}

        return response('You are now a subscriber.', 200);
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

    public function updateCard(Request $request, User $user)
    {
        $this->checkToken($request, $user);

        try {
            $token = $this->token($request);
            $user->updateCard($token->id);
        } catch(\Exception $e) {
            return $e->getMessage();
        }

        return response('Your credit card has been updated!', 200);
    }

    private function token($request)
	{
        return Token::create([
            "card" => [
                "number" => $request->number,
                "exp_month" => $request->month,
                "exp_year" => $request->year,
                "cvc" => $request->cvc
            ]
        ]);
	}

    private function checkToken($request, $user)
    {
        if($user->api_token != $request->apiToken) {
            return response('Token mismatch!', 401);
        }
    }
}
