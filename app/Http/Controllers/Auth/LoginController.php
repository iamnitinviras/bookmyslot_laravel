<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Subscriptions;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Define controller middleware for Laravel 12.
     *
     * @return array
     */
    public static function middleware(): array
    {
        return [
            'guest' => ['except' => ['logout']],
            'auth' => ['only' => ['logout']],
        ];
    }

    protected function credentials(Request $request)
    {
        return [
            'email' => $request->{$this->username()},
            'password' => $request->password,
            'status' => 'active',
        ];
    }


    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->scopes(['email'])->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();
        $authUser = $this->CreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect('/');
    }

    public function CreateUser($user, $provider)
    {
        $authUser = User::where('email', $user->email)->first();
        if ($authUser) {
            return $authUser;
        }

        $days = config('custom.trial_days');
        $trial_expire_at = \Carbon\Carbon::now()->addDays($days)->format("Y-m-d H:i:s");

        $fullname = explode(" ", $user->name);
        $user = User::create(
            [
                'first_name' => isset($fullname[0]) ? $fullname[0] : "",
                'last_name' => isset($fullname[1]) ? $fullname[1] : "",
                'email' => $user->email,
                'status' => User::STATUS_ACTIVE,
                'user_type' => User::USER_TYPE_VENDOR,
                'provider' => $provider,
                'provider_id' => $user->id,
                'email_verified_at' => now(),
            ]
        );

        $user->assignRole("vendor");

        $vendorPlan = new Subscriptions();
        $vendorPlan->user_id = $user->id;
        $vendorPlan->plan_id = 0;
        $vendorPlan->start_date = now();
        $vendorPlan->expiry_date = $trial_expire_at;
        $vendorPlan->is_current = 'yes';
        $vendorPlan->payment_method = 'Trial';
        $vendorPlan->amount = 0;
        $vendorPlan->type = "trial";

        $vendorPlan->unlimited_branch = "no";
        $vendorPlan->unlimited_member = "no";
        $vendorPlan->staff_unlimited = "no";

        $vendorPlan->member_limit = config('custom.trial_member');
        $vendorPlan->branch_limit = config('custom.trial_branch');
        $vendorPlan->staff_limit = config('custom.trial_staff');

        $vendorPlan->status = 'approved';
        $vendorPlan->details = "Vendor Trial";
        $vendorPlan->save();

        return $user;
    }
}
