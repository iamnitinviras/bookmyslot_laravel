<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductUser;
use App\Models\Business;
use App\Models\BusinessUser;
use App\Models\Category;
use App\Models\Feedback;
use App\Models\FeedbackComments;
use App\Models\Items;
use App\Models\Roadmap;
use App\Models\Settings;
use App\Models\SubCategory;
use App\Models\Subscriptions;
use App\Models\Transactions;
use App\Models\User;
use App\Models\VendorSetting;
use App\Models\WebhookData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        return view('admin.profile.index', ['user' => $user]);
    }

    public function edit()
    {
        $user = auth()->user();
        return view('admin.profile.edit', ['user' => $user]);
    }

    public function update()
    {
        $user = auth()->user();
        $request = request();
        $input = $request->only('first_name','email', 'last_name', 'phone_number', 'language', 'city', 'state', 'country', 'zip', 'address', 'profile_image');
        $request->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'last_name' => ['required', 'string', 'max:50'],
            'phone_number' => ['required', 'string', 'max:20'],
            'profile_image' => ['max:10000', "image", 'mimes:jpeg,png,jpg,gif,svg'],
        ], [
            "first_name.required" => __('validation.required', ['attribute' => 'first name']),
            "first_name.string" => __('validation.custom.invalid', ['attribute' => 'first name']),

            "last_name.required" => __('validation.required', ['attribute' => 'last name']),
            "last_name.string" => __('validation.custom.invalid', ['attribute' => 'last name']),

            "phone_number.required" => __('validation.required', ['attribute' => 'phone number']),
            "phone_number.regex" => __('validation.custom.invalid', ['attribute' => 'phone number']),

            "profile_image.max" => __('validation.gt.file', ['attribute' => 'profile image', 'value' => 10000]),
            "profile_image.image" => __('validation.enum', ['attribute' => 'profile image']),
            "profile_image.mimes" => __('validation.enum', ['attribute' => 'profile image']),

        ]);

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.profile.menu')]));

        $user->fill($input);
        $user->save();
        return redirect(route('admin.profile'));
    }

    public function passwordEdit()
    {
        $user = auth()->user();
        return view('admin.password.edit', ['user' => $user]);
    }

    public function passwordUpdate()
    {
        $user = auth()->user();
        $request = request();

        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!\Hash::check($value, $user->password)) {
                    return $fail(__('validation.custom.currentpassword'));
                }
            }],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'different:current_password'],

        ], [
            "password.required" => __('validation.required', ['attribute' => 'new password']),
            "password.string" => __('validation.password.invalid', ['attribute' => 'new password']),
            "password.different" => __('validation.custom.samepassword', ['attribute' => 'new password']),
        ]);
        $user->password = Hash::make($request->password);
        $user->save();
        $request->session()->flash('Success', __('system.messages.change_success_message', ['model' => __('system.password.title')]));

        return redirect(route('admin.profile'));
    }

    public function delete(){
        $user = auth()->user();
        if ($user->user_type==User::USER_TYPE_ADMIN){
            return redirect('home');
        }

        //Delete Restro entry.
        if ($user->user_type==User::USER_TYPE_STAFF){
            ProductUser::where('user_id',$user->id)->delete();
        }


        if ($user->user_type==User::USER_TYPE_VENDOR){

            $subscriptions=Subscriptions::where('user_id',$user->id)->whereNotNull('subscription_id')->get();

            //Delete Vendor Associated Data.
            ProductUser::where('user_id',$user->id)->delete();
            VendorSetting::where('user_id',$user->id)->delete();
            Transactions::where('user_id',$user->id)->delete();
            User::where('created_by',$user->id)->where('user_type',User::USER_TYPE_STAFF)->delete();

            //Delete Restaurant
            $vendor_products=Branch::where('user_id',$user->id)->get();
            if (isset($vendor_products) && count($vendor_products)>0){
                foreach ($vendor_products as $user_board){
                    Feedback::where('branch_id',$user_board->id)->delete();
                    FeedbackComments::where('branch_id',$user_board->id)->delete();
                    Category::where('branch_id',$user_board->id)->delete();
                    Roadmap::where('branch_id',$user_board->id)->delete();
                    $user_board->delete();
                }
            }

            //Get All Subscription
            if (isset($subscriptions) && count($subscriptions)>0){

                $stripe_data = Settings::where('title', 'stripe')->first();
                $stripePayment = ($stripe_data != null) ? json_decode($stripe_data->value) : array();
                $stripe_secret_key = isset($stripePayment->stripe_secret_key) ? $stripePayment->stripe_secret_key : '';

                if (isset($stripe_secret_key) && $stripe_secret_key!=""){
                    $stripe = new \Stripe\StripeClient($stripe_secret_key);

                    foreach ($subscriptions as $subscription){
                        $result=$stripe->subscriptions->cancel(
                            $subscription->subscription_id,
                            []
                        );
                        if(isset($result->status) && $result->status=='canceled'){
                            $subscription->delete();
                        }
                    }
                }

            }
        }

        $user->delete();
        return redirect('login')->with('Success',trans('system.profile.delete_success'));
    }

    public function webhookData(Request $request){
        if (isset($request->subscription) && $request->subscription!=null){
            $sub_data=Subscriptions::orderBy('id','desc')->get();
        }

        $webhook_data=WebhookData::orderBy('id','desc')->paginate(10);
        return view('admin.settings.webhook_data',compact('webhook_data'));
    }
}

