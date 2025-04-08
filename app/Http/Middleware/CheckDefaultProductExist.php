<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class CheckDefaultProductExist
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if ($user->user_type != User::USER_TYPE_ADMIN) {

            //Send for email verification
            if ($user->user_type === User::USER_TYPE_VENDOR) {
                if ($user->email_verified_at == null) {
                    return redirect('verify-email');
                }
            }

            if ($user->user_type == User::USER_TYPE_STAFF) {
                $user = User::find($user->created_by);
            }

            if (!$user->free_forever) {
                $redirectLocation = "vendor/plan";

                if (auth()->user()->user_type == User::USER_TYPE_STAFF) {
                    $redirectLocation = "staff/plan";
                }

                //If not current plan then send back plan purchase
                if ($user->isExpired()) {
                    return redirect($redirectLocation)->with('Error', __('system.plans.subscription_expire'));
                }
            }
        }
        return $next($request);
    }
}
