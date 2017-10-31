<?php

namespace App\Http\Controllers;

use App\User;
use Stripe\{Stripe,Token,Subscription};
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
            return response($user->id, 422);
    	}

        return response('You are now a subscriber.', 200);
    }

    public function resubscribe(User $user)
    {
        $this->checkToken($user);

        try {
            $user->newSubscription('main', $this->request->plan)
                ->create(null);
        } catch(\Exception $e) {
            return response($user->id, 422);
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
            try {
                $user->subscription('main')->resume();
            } catch(\Exception $e) {
                return response($e->getMessage(), 422);
            }
            return response('You are now subscribed!', 200);
        }

        return response('Your subscription has ended, it can\'t be resumed!', 422);
    }

    public function cancel(User $user)
    {	
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

    public function invoices(User $user)
    {
        $this->checkToken($user);

        try {
            $invoices = $user->invoices();
            foreach($invoices as $key => $invoice) {
                $json[$key]['date'] = $invoice->date()->toFormattedDateString();
                $json[$key]['total'] = $invoice->total();
                $json[$key]['id'] = $invoice->id;
            }
        } catch(\Exception $e) {
            return response($e->getMessage(), 422);
        }

        return $json ?: '';
    }

    public function invoice(User $user)
    {
        $this->checkToken($user);

        try {
            return $user->downloadInvoice($this->request->invoiceId, [
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

        if($request->plan != 'Daily' && $request->plan != 'Monthly') return 'Plan doesn\'t exist!';
    }
}
