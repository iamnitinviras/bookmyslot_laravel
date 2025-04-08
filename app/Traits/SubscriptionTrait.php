<?php

namespace App\Traits;

use App\Models\Subscriptions;

trait SubscriptionTrait
{
    public function subscription()
    {
        return $this->hasOne('App\Models\Subscriptions')->where('is_current', 'yes');
    }

    public function isSubscribed()
    {
        return $this->subscription()->exists() && $this->subscription->status === 'approved';
    }

    public function subscriptionData()
    {
        return $this->subscription;
    }

    public function isExpired()
    {
        if ($this->subscription()->exists()) {
            if ($this->subscription->type == 'onetime') {
                return false;
            } else {
                if (date($this->subscription->expiry_date, strtotime('Y-m-d')) < date('Y-m-d')) {
                    return true;
                }
            }
        } else {
            return true;
        }
    }
}
