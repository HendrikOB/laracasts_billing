<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class WebhooksController extends Controller
{
    public function handle()
    {
    	$payload = request()->all();

    	$method = $this->eventToMethod($playload['type']);

    	if (method_exists($this, $method)) {
    		$this->$method($payload);
    	}

    	return response('Webhook Received');
    }

    public function whenCustomerSubscriptionDeleted($payload)
    {
    	User::where('stripe_id', $payload['data']['object']['customer'])->deactivate();
    }

    public function eventToMethod($event)
    {
    	return 'when' . studly_case(str_replace('.', '_', $event));
    }
}
