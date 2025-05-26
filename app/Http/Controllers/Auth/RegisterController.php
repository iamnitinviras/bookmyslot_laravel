<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Subscriptions;
use App\Models\User;
use App\Models\VendorSetting;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

#[Middleware('guest')]
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $lbl_phone_number = strtolower(__('system.fields.phone_number'));
        $lbl_first_name = strtolower(__('system.fields.first_name'));
        $lbl_last_name = strtolower(__('system.fields.last_name'));
        $lbl_email = strtolower(__('system.fields.email'));
        $lbl_password = strtolower(__('system.fields.password'));

        return Validator::make($data, ['first_name' => ['required', 'string', 'max:50'], 'last_name' => ['required', 'string', 'max:50'], 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], 'phone_number' => ['required', 'unique:users,phone_number'], 'password' => ['required', 'string', 'min:8'],], [
            "first_name.required" => __('validation.required', ['attribute' => $lbl_first_name]),
            "first_name.string" => __('validation.custom.invalid', ['attribute' => $lbl_first_name]),

            "last_name.required" => __('validation.required', ['attribute' => $lbl_last_name]),
            "last_name.string" => __('validation.custom.invalid', ['attribute' => $lbl_last_name]),

            "phone_number.required" => __('validation.required', ['attribute' => $lbl_phone_number]),
            "phone_number.regex" => __('validation.custom.invalid', ['attribute' => $lbl_phone_number]),
            "phone_number.unique" => __('validation.unique', ['attribute' => $lbl_phone_number]),

            "email.required" => __('validation.required', ['attribute' => $lbl_email]),
            "email.string" => __('validation.custom.invalid', ['attribute' => $lbl_email]),
            "email.email" => __('validation.custom.invalid', ['attribute' => $lbl_email]),
            "email.unique" => __('validation.unique', ['attribute' => $lbl_email]),

            "password.required" => __('validation.required', ['attribute' => $lbl_password]),
            "password.string" => __('validation.password.invalid', ['attribute' => $lbl_password]),
            "password.regex" => __('validation.password.invalid', ['attribute' => $lbl_password]),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $days = config('custom.trial_days');
        $trial_expire_at = \Carbon\Carbon::now()->addDays($days)->format("Y-m-d H:i:s");

        $user = User::create(
            [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'password' => Hash::make($data['password']),
                'status' => User::STATUS_ACTIVE,
                'user_type' => User::USER_TYPE_VENDOR
            ]
        );

        VendorSetting::updateOrCreate(['user_id' => $user->id], []);

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

        event(new Registered($user));

        return $user;
    }
}
