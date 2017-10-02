<?php

namespace App\Http\Controllers;

use App\User;
use Stripe\{Stripe,Token};
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $request;

	public function __construct(Request $request)
	{
        $this->request = $request;
		Stripe::setApiKey(config('services.stripe.secret'));
	}

    public function subscribe(User $user)
    {
    	$this->checkToken($user);

    	try {
    		$token = $this->token();
    		$user->newSubscription('main', $this->request->plan)
				->create($token->id);
    	} catch(\Exception $e) {
            return response($e->getMessage(), 422);
    	}

        return response('You are now a subscriber.', 200);
    }

    public function changePlan(User $user)
    {
    	$this->checkToken($user);

        try {
            $user->subscription('main')->swap($this->request->plan);
        } catch(\Exception $e) {
            return response($e->getMessage(), 422);
        }
		
        return response('Your plan has been changed!', 200);
    }

    public function resume(User $user)
    {
        $this->checkToken($user);
        
        if ($user->subscription('main')->onGracePeriod()) {
            $user->subscription('main')->resume();
        }
    }

    public function cancel(User $user)
    {	// todo: when user in trial, hide cancel button.
        $this->checkToken($user);

        try {
            $user->subscription('main')->cancel();
        } catch(\Exception $e) {
            return response($e->getMessage(), 422);
        }

        return response('Your subscription has been canceled!', 200);
    }

    public function updateCard(User $user)
    {
        $this->checkToken($user);

        try {
            $token = $this->token();
            $user->updateCard($token->id);
        } catch(\Exception $e) {
            return response($e->getMessage(), 422);
        }

        return response('Your credit card has been updated!', 200);
    }

    public function getToken()
    {
        try {
            $token = $this->token();
        } catch(\Exception $e) {
            return response($e->getMessage(), 422);
        }

        return $token->id;
    }

    private function token()
	{
        return Token::create([
            "card" => [
                "number" => $this->request->number,
                "exp_month" => $this->request->month,
                "exp_year" => $this->request->year,
                "cvc" => $this->request->cvc
            ]
        ]);
	}

    private function checkToken($user)
    {
        if($user->api_token != $this->request->apiToken) {
            return response('Token mismatch!', 401);
        }
    }
}
