<?php

namespace Tests\Feature;

use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StripeTest extends TestCase
{
	use RefreshDatabase;

	public function setUp()
	{
		parent::setUp();

		Passport::actingAs(
	        factory('App\User')->create()
	    );
	}

    public function test_check_plan_exists_b4_get_token()
    {
        $this->post('/api/token')->assertSee('Choose a plan!');
    }

    public function test_check_valid_plans_b4_get_token()
    {
        $this->post('/api/token', ['plan' => 'fefef'])->assertSee('Plan doesn\'t exist!');
    }
}
