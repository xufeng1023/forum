<?php

namespace App\Http\Controllers;

use Stripe\{Stripe,Token,Subscription};
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $request;

	public function __construct(Request $request)
	{
        $this->request = $request;
        $this->middleware('auth:api');
		Stripe::setApiKey(config('services.stripe.secret'));
	}

    public function subscribe()
    {
        try {
            if(auth()->user()->stripe_id) $token = null;
            else $token = $this->token()->id;
        } catch(\Exception $e) {
            return response('card', 422);
        }

        try {
            if($this->request->plan == 'ppv') {
                auth()->user()->createAsStripeCustomer($token);
            } else {
                auth()->user()->newSubscription('main', $this->request->plan)->create($token);
            }

            return response('/settings/invoices', 200);

        } catch(\Exception $e) {
            return response('pay', 422);
        }
    }

    public function ppv()
    {
        try {
            auth()->user()->invoiceFor('One Time Charge', 149);
        } catch(\Exception $e) {
            return response('failed', 422);
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

    public function resume()
    {
        if (auth()->user()->subscription('main')->onGracePeriod()) {
            try {
                auth()->user()->subscription('main')->resume();
            } catch(\Exception $e) {
                return response($e->getMessage(), 422);
            }
            return response('/settings/invoices', 200);
        }

        return response('Your subscription has ended, it can\'t be resumed!', 422);
    }

    public function cancel()
    {	
        try {
            auth()->user()->subscription('main')->cancel();
        } catch(\Exception $e) {
            return response($e->getMessage(), 422);
        }

        return response('Your subscription has been canceled!', 200);
    }

    public function updateCard()
    {
        try {
            $token = $this->token();
            auth()->user()->updateCard($token->id);
        } catch(\Exception $e) {
            return response($e->getMessage(), 422);
        }

        return response('Your credit card has been updated!', 200);
    }

    public function invoices()
    {
        try {
            $invoices = auth()->user()->invoices();
            foreach($invoices as $key => $invoice) {
                $json[$key]['date'] = $invoice->date()->format('Y-m-d');
                $json[$key]['total'] = $invoice->total();
                $json[$key]['id'] = $invoice->id;
            }
        } catch(\Exception $e) {
            return response($e->getMessage(), 422);
        }

        return isset($json)? $json : '';
    }

    public function invoice()
    {
        try {
            return auth()->user()->downloadInvoice($this->request->invoiceId, [
                'vendor'  => 'DollyIsland',
                'product' => 'Membership',
            ]);
        } catch(\Exception $e) {
            return response($e->getMessage(), 422);
        }
    }

    public function getToken(Request $request)
    {
        if($msg = $this->isBadPlan($request)) return response(['plan' => $msg], 422);

        try {
            $token = $this->token();
        } catch(\Exception $e) {
            return response(['card' => $e->getMessage()], 422);
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
            return response(['token' => 'Token mismatch!'], 401);
        }
    }

    private function isBadPlan($request)
    {
        if(!$request->has('plan')) return 'Choose a plan!';

        if($request->plan != 'ppv' && $request->plan != 'monthly') return 'Plan doesn\'t exist!';
    }
}
