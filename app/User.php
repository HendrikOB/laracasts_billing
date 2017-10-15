<?php

namespace App;


use App\Subscription;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'stripe_id', 'stripe_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function byStripeId($stripeId)
    {
        return static::where('stripe_id', $stripeId)->firstOrFail();
    }

    public function activate($customerId = null)
    {
        return $this->forceFill([
            'stripe_id' => $customerId ?? $this->stripe_id,
            'stripe_active' => true,
            'subscription_end_at' => null
        ])->save();
    }

    public function deactivate()
    {
        return $this->forceFill([
            'stripe_active' => false,
            'subscription_end_at' => \Carbon\Carbon::now()
        ])->save();
    }

    public function subscription()
    {
        return new Subscription($this);
    }

    public function isSUbscribed()
    {
        return !! $this->stripe_active;
    }
}
