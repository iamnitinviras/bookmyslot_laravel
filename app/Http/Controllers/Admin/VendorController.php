<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Payment\PayPalController;
use App\Http\Controllers\Admin\Payment\RazorpayController;
use App\Http\Controllers\Admin\Payment\StripeController;
use App\Models\Branch;
use App\Models\User;
use App\Models\Plans;
use Illuminate\Support\Arr;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Models\Subscriptions;
use App\Models\VendorSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Session;
use Stripe\Subscription;
use App\Services\SubscriptionService;

class VendorController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function index()
    {
        $request = request();
        $vendor = auth()->user();
        $params = $request->only('par_page', 'sort', 'direction', 'filter');
        $par_page = config('custom.per_page');
        if (in_array($request->par_page, [10, 25, 50, 100])) {
            $par_page = $request->par_page;
        }
        $params['par_page'] = $par_page;
        $params['user_id'] = $vendor->id;

        $vendors = (new UserRepository())->getOwners($params);
        if ($request->user_list == 'all') {
            $vendors->load('products');
        }

        $plans = Plans::where('status', 'active')->pluck('title', 'plan_id')->toArray();
        return view('admin.vendors.index', ['vendors' => $vendors, 'plans' => $plans]);
    }

    public function create()
    {
        $plans = Plans::where('status', 'active')->orderBy('title', 'asc')->get();
        return view('admin.vendors.create', compact('plans'));
    }

    public function show(User $vendor)
    {
        if (isset($vendor->user_type) && $vendor->user_type != 3) {
            return back();
        }

        $total_board = Branch::where('user_id', $vendor->id)->count();
        $total_staff = User::where('created_by', $vendor->id)->count();

        $current_plans = $vendor->subscriptionData();
        $plan_id = $vendor->subscriptionData() ? $vendor->subscriptionData()->plan_id : 0;
        $plans = Plans::where('plan_id', $plan_id)->first();

        return view('admin.vendors.show', compact('vendor', 'total_staff', 'total_board', 'plans', 'current_plans'));
    }

    public function paymentTransactions($vendor_id)
    {
        $vendor = User::where('id', $vendor_id)->first();
        if (empty($vendor)) {
            abort(404);
        }

        if (auth()->user()->user_type != User::USER_TYPE_ADMIN) {
            return redirect('home');
        }

        $transactions = Transactions::where('user_id', $vendor->id)->with([
            'subscription' => function ($subQuery)
            {
                $subQuery->select('id', 'payment_method');
            }
        ])->orderBy('created_at', 'desc')->get();
        return view('admin.vendors.payment-transaction', compact('vendor', 'transactions'));
    }

    public function subscriptionHistory($vendor_id)
    {
        $vendor = User::where('id', $vendor_id)->first();
        if (empty($vendor)) {
            abort(404);
        }

        if (auth()->user()->user_type != User::USER_TYPE_ADMIN) {
            return redirect('home');
        }

        $subscriptions = Subscriptions::where('user_id', $vendor_id)->orderBy('created_at', 'desc')->get();
        return view('admin.vendors.subscription-transaction', compact('vendor', 'subscriptions'));
    }

    public function store(UserRequest $request)
    {
        $vendor = auth()->user();
        $data = $request->all();
        $plan_id = (int) request()->user_plan;

        $plan = Plans::where('plan_id', $plan_id)->first();
        $free_forever = false;
        if ($plan == null) {
            $free_forever = true;
        }

        $newUser = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'profile_image' => $data['profile_image'] ?? null,
            'password' => Hash::make($data['password']),
            'user_type' => User::USER_TYPE_VENDOR,
            'status' => User::STATUS_ACTIVE,
            'created_by' => $vendor->id,
            'email_verified_at' => now(),
            'free_forever' => $free_forever,
            'branch_id' => null,
            'address' => $data['address'],
            'city' => $data['city'],
            'state' => $data['state'],
            'country' => $data['country'],
            'zip' => $data['zip']
        ]);
        $newUser->assignRole("vendor");

        VendorSetting::updateOrCreate(['user_id' => $newUser->id], []);

        $expiredDate = null;
        if ($plan != null) {
            if ($plan->type == 'weekly') {
                $expiredDate = now()->addWeek();
            } else if ($plan->type == 'monthly') {
                $expiredDate = now()->addMonth();
            } else if ($plan->type == 'yearly') {
                $expiredDate = now()->addYear();
            } else if ($plan->type == 'day') {
                $expiredDate = now()->addDay();
            }
        }

        $vendorPlan = new Subscriptions();
        $vendorPlan->user_id = $newUser->id;
        $vendorPlan->start_date = now();
        $vendorPlan->expiry_date = $expiredDate;
        $vendorPlan->is_current = 'yes';
        $vendorPlan->payment_method = 'manually';
        $vendorPlan->status = 'approved';
        $vendorPlan->details = trans('system.plans.manually_added_by_admin');

        if ($plan == null) {
            $vendorPlan->plan_id = 0;
            $vendorPlan->amount = 0;
            $vendorPlan->type = 'free';
            $vendorPlan->branch_limit = 0;
            $vendorPlan->unlimited_branch = "yes";
            $vendorPlan->staff_unlimited = "yes";
        } else {
            $vendorPlan->plan_id = $plan->plan_id;
            $vendorPlan->amount = $plan->amount;
            $vendorPlan->type = $plan->type;
            $vendorPlan->branch_limit = $plan->branch_limit;
            $vendorPlan->staff_limit = $plan->staff_limit;
            $vendorPlan->unlimited_branch = $plan->unlimited_branch;
            $vendorPlan->staff_unlimited = $plan->staff_unlimited;
        }

        $vendorPlan->save();

        if ($plan != null) {
            Transactions::create([
                'transaction_id' => time(),
                'user_id' => $vendor->id,
                'plan_id' => $plan->plan_id,
                'subscription_id' => $vendorPlan->id,
                'amount' => $plan->amount,
                'details' => trans('system.plans.manually_added_by_admin'),
            ]);
        }

        $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.vendors.title')]));

        return redirect(route('admin.vendors.index'));
    }

    public function edit(User $vendor)
    {
        if (isset($vendor->user_type) && $vendor->user_type == 1) {
            return back();
        }

        $plans = Plans::where('status', 'active')->orderBy('title', 'asc')->get();

        return view('admin.vendors.edit', ['vendor' => $vendor, 'plans' => $plans]);
    }

    public function update(UserRequest $request, User $vendor)
    {

        if (isset($vendor->user_type) && $vendor->user_type != 3) {
            return back();
        }

        $data = $request->only('first_name', 'email', 'last_name', 'phone_number', 'permission', 'profile_image', 'address', 'city', 'state', 'country', 'zip');

        if (empty($vendor->email_verified_at)) {
            $data['email_verified_at'] = now();
        }

        $data['user_type'] = 3;
        $vendor->fill($data)->save();

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.vendors.title')]));

        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('admin.vendors.index'));
    }


    public function destroy(User $vendor)
    {
        $request = request();
        if (isset($vendor->user_type) && $vendor->user_type != User::USER_TYPE_VENDOR) {
            return back();
        }

        $subscriptions = Subscriptions::where('user_id', $vendor->id)->whereNotNull('subscription_id')->get();

        Subscriptions::where('user_id', $vendor->id)->whereNull('subscription_id')->delete();

        //Delete Vendor Associated Data.
        Transactions::where('user_id', $vendor->id)->delete();
        User::where('created_by', $vendor->id)->where('user_type', User::USER_TYPE_STAFF)->delete();


        //Get All Subscription
        if (isset($subscriptions) && count($subscriptions) > 0) {

            $stripe_secret_key = config('stripe.stripe_secret_key');

            if (isset($stripe_secret_key) && $stripe_secret_key != "") {
                $stripe = new \Stripe\StripeClient($stripe_secret_key);

                foreach ($subscriptions as $subscription) {
                    $result = $stripe->subscriptions->cancel($subscription->subscription_id, []);
                    if (isset($result->status) && $result->status == 'canceled') {
                        $subscription->delete();
                    }
                }
            }

        }

        $vendor->delete();
        $request->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.vendors.title')]));

        if ($request->back) {
            return redirect($request->back);
        }

        return redirect(route('admin.vendors.index'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function setting()
    {
        $vendor = auth()->user();
        if ($vendor->user_type != User::USER_TYPE_VENDOR) {
            return redirect('home');
        }
        $vendorSetting = config('vendor_setting');
        return view("admin.vendors_setting.index", compact('vendorSetting'));
    }

    public function settingUpdate(Request $request)
    {
        $vendor = auth()->user();
        if ($vendor->user_type != 3) {
            return redirect('home');
        }

        $currency = Arr::where(getAllCurrencies(), function ($value, $key)
        {
            if (request()->default_currency == $key) {
                return $value;
            }
        });
        $currency = explode('-', array_values($currency)[0]);

        $file_validation = [!empty(config('vendor_setting')) ? 'nullable' : 'required', 'max:50000', "image", 'mimes:jpeg,png,jpg,gif,svg'];
        $attributes = $request->validate(["analytics_code" => "nullable", "default_currency" => "required", "default_currency_position" => "required",]);

        $attributes['analytics_code'] = $request->analytics_code;
        $attributes['default_currency'] = trim($currency[1]);
        $attributes['default_currency_symbol'] = trim($currency[0]);

        VendorSetting::updateOrCreate(['user_id' => $vendor->id,], $attributes);

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.environment.title')]));
        return redirect()->back();
    }


    public function updatePassword(Request $request, User $vendor)
    {
        try {

            $this->validate($request, ['new_password' => ['required', 'string', 'min:8'], 'confirm_password' => ['required', 'same:new_password']]);

            $vendor->password = Hash::make($request->new_password);
            $vendor->save();

            return back()->with('Success', __('system.messages.change_success_message', ['model' => __('system.fields.password')]));
        } catch (\ErrorException $e) {
            $request->session()->flash('Success', $e->getMessage());
            return back();
        }
    }

    public function makeInactive(Request $request, User $vendor)
    {
        try {
            $vendor->status = 'inactive';
            $vendor->save();
            return back()->with('Success', __('system.messages.updated', ['model' => __('system.vendors.title')]));
        } catch (\ErrorException $e) {
            $request->session()->flash('Success', $e->getMessage());
            return back();
        }
    }

    public function makeActive(Request $request, User $vendor)
    {
        try {
            $vendor->status = 'active';
            $vendor->save();
            return back()->with('Success', __('system.messages.updated', ['model' => __('system.vendors.title')]));
        } catch (\ErrorException $e) {
            $request->session()->flash('Success', $e->getMessage());
            return back();
        }
    }

    public function verifyEmail(Request $request, User $vendor)
    {
        try {
            $vendor->email_verified_at = date('Y-m-d H:i:s');
            $vendor->save();
            return back()->with('Success', __('system.messages.updated', ['model' => __('system.vendors.title')]));
        } catch (\ErrorException $e) {
            $request->session()->flash('Success', $e->getMessage());
            return back();
        }
    }


    public function staffPlan()
    {
        return view("admin.vendor_subscription.staff");
    }

    public function support()
    {
        return view("admin.vendor_subscription.support");
    }
    public function changePlan(User $vendor)
    {
        $plans = Plans::where('status', 'active')->where(function ($query) use ($vendor)
        {
            $query->whereNull('user_id')->orWhere('user_id', $vendor->id);
        })->get();

        $subscription = $vendor->subscriptionData();
        return view("admin.vendors.change_plan", compact('plans', 'vendor', 'subscription'));
    }
    public function updatePlan(User $vendor, Request $request)
    {
        $plan = Plans::where('plan_id', $request->plan_id)->first();
        if ($plan == null) {
            return redirect(route('admin.vendors.show', $vendor->id));
        }

        $subscription = Subscriptions::where('user_id', $vendor->id)->where('is_current', 'yes')->first();

        $expiredDate = null;
        if ($plan->type == 'weekly') {
            $expiredDate = now()->addWeek();

        } else if ($plan->type == 'monthly') {
            $expiredDate = now()->addMonth();

        } else if ($plan->type == 'yearly') {
            $expiredDate = now()->addYear();

        } else if ($plan->type == 'day') {
            $expiredDate = now()->addDay();
        }
        // dd($expiredDate);

        $subscription_data_array = array(
            'plan_id' => $plan->plan_id,
            'is_current' => 'yes',
            'payment_method' => 'manually',
            'amount' => $plan->amount,
            'type' => $plan->type,
            'branch_limit' => $plan->branch_limit,
            'staff_limit' => $plan->staff_limit,
            'staff_unlimited' => $plan->staff_unlimited,
            'unlimited_branch' => $plan->unlimited_branch,
            'status' => 'approved',
            'expiry_date' => $expiredDate,
            'created_at' => now(),
            'updated_at' => now(),
            'start_date' => now(),
            'details' => trans('system.plans.manually_added_by_admin'),
        );

        if ($subscription == null) {
            Subscriptions::updateOrCreate(['user_id' => $vendor->id], $subscription_data_array);

        } elseif (isset($subscription) && $subscription != null && $subscription->subscription_id == null) {
            Subscriptions::updateOrCreate(['id' => $subscription->id], $subscription_data_array);

        } else {
            $subscription_id = $subscription->subscription_id;
            $payment_method = $subscription->payment_method;
            if ($payment_method == 'stripe') {

                $currency = config('custom.currency');
                $stripe_secret_key = config('stripe.stripe_secret_key');

                if ($plan->type == 'weekly') {
                    $recurring_type = 'week';
                } else if ($plan->type == 'monthly') {
                    $recurring_type = 'month';
                } else if ($plan->type == 'yearly') {
                    $recurring_type = 'year';
                } else if ($plan->type == 'day') {
                    $recurring_type = 'day';
                } else {
                    $recurring_type = '';
                }

                //Subscription
                $stripe = new \Stripe\StripeClient($stripe_secret_key);
                \Stripe\Stripe::setApiKey($stripe_secret_key);

                //Product
                $stripe_plan_id = $plan->stripe_plan_id;

                if ($plan->stripe_plan_id == null) {
                    $product = $stripe->products->create([
                        'name' => $plan->title,
                    ]);

                    $stripe_plan_id = $product->id;
                    $plan->stripe_plan_id = $product->id;
                    $plan->save();
                }

                //Price
                $price_array = [
                    'unit_amount' => $plan->amount * 100,
                    'currency' => $currency,
                    'product' => $stripe_plan_id,
                ];

                $price_array['recurring'] = ['interval' => $recurring_type];
                $price = $stripe->prices->create($price_array);
                $subscription = Subscription::retrieve($subscription_id);

                // Get subscription item ID (needed for update)
                $subscriptionItemId = $subscription->items->data[0]->id;

                // Update the subscription with new price
                Subscription::update($subscription_id, [
                    'items' => [
                        [
                            'id' => $subscriptionItemId,
                            'price' => $price->id,
                        ],
                    ],
                    'proration_behavior' => 'create_prorations'
                ]);
            } elseif ($payment_method == 'paypal') {
                (new PayPalController($this->subscriptionService))->cancelSubscription($subscription_id);
            } elseif ($payment_method == 'razorpay') {
                (new RazorpayController($this->subscriptionService))->cancelSubscription($subscription_id);
            }
            Subscriptions::where('id', $subscription->id)->update($subscription_data_array);
        }

        return redirect(route('admin.vendors.show', $vendor->id))->with('Success', __('system.messages.updated', ['model' => __('system.vendors.title')]));
    }

    public function subscriptionCancel(Subscriptions $subscription)
    {
        try {

            if ($subscription == null) {
                throw new \Exception(__('system.messages.not_found', ['model' => __('system.plans.subscription')]));
            }

            $userPlan = Subscriptions::where('id', $subscription->id)->first();

            if ($userPlan == null) {
                throw new \Exception(__('system.messages.not_found', ['model' => __('system.plans.subscription')]));
            }

            //Cancel Subscription
            if ($userPlan->payment_method == "paypal") {
                return (new PayPalController($this->subscriptionService))->cancelSubscription($userPlan->subscription_id);

            } elseif ($userPlan->payment_method == "razorpay") {
                return (new RazorpayController($this->subscriptionService))->cancelSubscription($userPlan->subscription_id);

            } elseif ($userPlan->payment_method == "stripe") {
                return (new StripeController($this->subscriptionService))->subscriptionCancel($userPlan);

            }
            return redirect()->back()->with('Success', trans('system.plans.cancel_subscription_success'));

        } catch (\Exception $exception) {
            return redirect('subscription')->with(['Error' => $exception->getMessage()]);
        }
    }

    public function vendorSignin(User $vendor)
    {
        $user = auth()->user();

        if ($user->user_type != User::USER_TYPE_ADMIN) {
            return redirect()->back();
        }

        if ($vendor->user_type != User::USER_TYPE_VENDOR) {
            return redirect()->back();
        }

        Session::put('super_admin_id', $user->id);
        Auth::loginUsingId($vendor->id, true);
        return redirect('home');
    }

    public function vendorLogout()
    {
        $user = auth()->user();
        if (Session::get('super_admin_id') == null) {
            return redirect('home');
        }
        $super_admin_id = Session::get('super_admin_id');
        Auth::loginUsingId($super_admin_id, true);
        Session::forget('super_admin_id');
        return redirect('home');
    }
}
