<?php

namespace App\Http\Controllers;

use Exception;
use App\Plan;
use Illuminate\Http\Request;
use Stripe\{Charge, Customer};

class SubscriptionsController extends Controller
{
    public function store()
    {
        $plan = Plan::findOrFail(request('plan'));

        try {
            $customer = Customer::create([
                'email' => request('stripeEmail'),
                'source' => request('stripeToken'),
                'plan' => $plan->name
            ]);
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }

        request()->user()->activate($customer->id);

        return [
            'status' => 'Success!'
        ];
    }
}
