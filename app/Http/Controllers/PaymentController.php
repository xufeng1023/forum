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
            return response($e->getMessage(), 422);
    	}

        return response('You are now a subscriber.', 200);
    }

    public function changePlan(Request $request, User $user)
    {
    	$this->checkToken($request, $user);

        try {
            $user->subscription('main')->swap($request->plan);
        } catch(\Exception $e) {
            return response($e->getMessage(), 422);
        }
		
        return response('Your plan has been changed!', 200);
    }

    public function cancel(Request $request, User $user)
    {	// todo: when user in trial, hide cancel button.
        $this->checkToken($request, $user);

        try {
            $user->subscription('main')->cancel();
        } catch(\Exception $e) {
            return response($e->getMessage(), 422);
        }

        return response('Your subscription has been canceled!', 200);
    }

    public function updateCard(Request $request, User $user)
    {
        $this->checkToken($request, $user);

        try {
            $token = $this->token($request);
            $user->updateCard($token->id);
        } catch(\Exception $e) {
            return response($e->getMessage(), 422);
        }

        return response('Your credit card has been updated!', 200);
    }

    public function token(Request $request)
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
