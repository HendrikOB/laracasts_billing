<?php

namespace App\Http\Controllers;

use App\Plan;
use Illuminate\Http\Request;
use Stripe\{Charge, Customer};

class SubscriptionsController extends Controller
{
    public function store()
    {
        $plan = Plan::findOrFail(request('plan'));

    	$customer = Customer::create([
    		'email' => request('stripeEmail'),
    		'source' => request('stripeToken'),
            'plan' => $plan->name
    	]);

    	return 'All done';
    }
}
