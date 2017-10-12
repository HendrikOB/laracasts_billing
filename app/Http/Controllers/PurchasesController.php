<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Stripe\{Charge, Customer};

class PurchasesController extends Controller
{
    public function store()
    {
    	$customer = Customer::create([
    		'email' => request('stripeEmail'),
    		'source' => request('stripeToken')
    	]);

    	Charge::create([
    		'customer' => $customer->id,
    		'amount' => 5000,
    		'currency' => 'usd'
    	]);

    	return 'All done';
    }
}
