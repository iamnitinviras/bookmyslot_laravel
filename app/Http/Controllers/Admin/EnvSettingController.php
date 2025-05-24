<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TestMail;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use App\Models\Plans;

class EnvSettingController extends Controller
{
    public static $timeformate = [
        'd/m/Y h:i' => ['date' => "d/m/Y", 'time' => 'h:i', 'value' => 'd/m/Y h:i (EX: 02/09/2022 10:37)',],
        'd-m-Y h:i' => ['date' => "d-m-Y", 'time' => 'h:i', 'value' => 'd-m-Y h:i (EX: 02-09-2022 10:37)',],
        'm-d-Y h:i' => ['date' => "m-d-Y", 'time' => 'h:i', 'value' => 'm-d-Y h:i (EX: 02/09/2022 10:37)',],
        'm/d/Y h:i' => ['date' => "m/d/Y", 'time' => 'h:i', 'value' => 'm/d/Y h:i (EX: 09/02/2022 10:37)',],
        'Y/m/d h:i' => ['date' => "Y/m/d", 'time' => 'h:i', 'value' => 'Y/m/d h:i  (EX: 2022/09/02 10:37)',],
        'Y-m-d h:i' => ['date' => "Y-m-d h:i", 'time' => 'h:i', 'value' => 'Y-m-d h:i  (EX: 2022-09-02 10:37)',],

        'd/m/Y H:i' => ['date' => "d/m/Y", 'time' => 'H:i', 'value' => 'd/m/Y H:i (EX: 02/09/2022 20:37)',],
        'd-m-Y H:i' => ['date' => "d-m-Y", 'time' => 'H:i', 'value' => 'd-m-Y H:i (EX: 02-09-2022 20:37)',],
        'm-d-Y H:i' => ['date' => "m-d-Y", 'time' => 'H:i', 'value' => 'm-d-Y H:i (EX: 02/09/2022 20:37)',],
        'm/d/Y H:i' => ['date' => "m/d/Y", 'time' => 'H:i', 'value' => 'm/d/Y H:i (EX: 09/02/2022 20:37)',],
        'Y/m/d H:i' => ['date' => "Y/m/d", 'time' => 'H:i', 'value' => 'Y/m/d H:i  (EX: 2022/09/02 20:37)',],
        'Y-m-d H:i' => ['date' => "Y-m-d H:i", 'time' => 'H:i', 'value' => 'Y-m-d H:i  (EX: 2022-09-02 20:37)',],

        'F j, Y, g:i a' => ['date' => "F j, Y", 'time' => 'g:i a', 'value' => 'F j, Y, g:i a (EX: March 10, 2001, 5:16 pm)',],
        'Y-m-d H:i:s' => ['date' => "Y-m-d", 'time' => 'H:i:s', 'value' => 'Y-m-d H:i:s (EX: 2001-03-10 17:16:18)',],
        'h:i A d/m/Y' => ['date' => "d/m/Y", 'time' => 'h:i A', 'value' => 'h:i A d/m/Y (EX: 17:16 AM 10/03/2022)',],
        'd/m/Y h:i A' => ['date' => "d/m/Y", 'time' => 'h:i A', 'value' => 'd/m/Y h:i A (EX: 10/03/2022 17:16 AM)',],
        'd F Y, h:i:s A' => ['date' => "d F Y", 'time' => 'h:i:s A', 'value' => 'd F Y, h:i:s A (EX: 13 September 2018, 11:05:00 AM)',],
    ];

    public function show()
    {
        return view('admin.settings.create');
    }

    public function update()
    {
        $request = request();

        $lbl_app_name = strtolower(__('system.fields.app_name'));
        $lbl_app_dark_logo = strtolower(__('system.fields.logo'));
        $lbl_app_light_logo = strtolower(__('system.fields.app_dark_logo'));
        $lbl_app_timezone = strtolower(__('system.fields.app_timezone'));
        $lbl_app_date_time_format = strtolower(__('system.fields.app_date_time_format'));

        $lbl_app_currency = __('system.fields.select_app_currency');
        $lbl_app_defult_language = __('system.fields.select_app_defult_language');
        $lbl_app_favicon_logo = __('system.fields.app_favicon_logo');
        $currencies = getAllCurrencies();
        $langs = getAllLanguages(1);
        $request->validate([
            'app_name' => ['required', 'string', 'min:2'],
            'app_dark_logo' => ['max:10000', "image", 'mimes:jpeg,png,jpg,gif,svg'],
            'app_light_logo' => ['max:10000', "image", 'mimes:jpeg,png,jpg,gif,svg'],
            'app_favicon_logo' => ['max:10000', "image", 'mimes:jpeg,png,jpg,gif,svg'],
            'app_timezone' => ['required', 'in:' . implode(',', array_keys(self::GetTimeZones()))],
            'app_date_time_format' => ['required'],
            'currency_position' => ['required', 'in:' . implode(',', array_keys(['left' => 'left', 'right' => 'right']))],
            'app_currency' => ['required', 'in:' . implode(',', array_keys($currencies))]
        ], [

            "app_name.required" => __('validation.required', ['attribute' => $lbl_app_name]),
            "app_name.string" => __('validation.custom.invalid', ['attribute' => $lbl_app_name]),
            "app_name.min" => __('validation.custom.invalid', ['attribute' => $lbl_app_name]),

            "app_dark_logo.max" => __('validation.gt.file', ['attribute' => $lbl_app_dark_logo, 'value' => 10000]),
            "app_dark_logo.image" => __('validation.enum', ['attribute' => $lbl_app_dark_logo]),
            "app_dark_logo.mimes" => __('validation.enum', ['attribute' => $lbl_app_dark_logo]),

            "app_light_logo.max" => __('validation.gt.file', ['attribute' => $lbl_app_light_logo, 'value' => 10000]),
            "app_light_logo.image" => __('validation.enum', ['attribute' => $lbl_app_light_logo]),
            "app_light_logo.mimes" => __('validation.enum', ['attribute' => $lbl_app_light_logo]),

            "app_favicon_logo.max" => __('validation.gt.file', ['attribute' => $lbl_app_favicon_logo, 'value' => 10000]),
            "app_favicon_logo.image" => __('validation.enum', ['attribute' => $lbl_app_favicon_logo]),
            "app_favicon_logo.mimes" => __('validation.enum', ['attribute' => $lbl_app_favicon_logo]),

            "app_timezone.required" => __('validation.required', ['attribute' => $lbl_app_timezone]),
            "app_timezone.in" => __('validation.enum', ['attribute' => $lbl_app_timezone]),

            "app_defult_language.required" => __('validation.required', ['attribute' => $lbl_app_defult_language]),
            "app_defult_language.in" => __('validation.enum', ['attribute' => $lbl_app_defult_language]),

            "app_date_time_format.required" => __('validation.required', ['attribute' => $lbl_app_date_time_format]),
            "app_date_time_format.in" => __('validation.enum', ['attribute' => $lbl_app_date_time_format]),

            "app_currency.required" => __('validation.required', ['attribute' => $lbl_app_currency]),

        ]);
        $dates = self::$timeformate[$request->app_date_time_format] ?? null;
        if ($dates == null) {
            $request->validate(['app_date_time_format' => ['in:_____'],], ["app_timezone.in" => __('validation.enum', ['attribute' => $lbl_app_timezone]),]);
        }
        $data = [
            'SUPPORT_EMAIL' => $request->support_email,
            'SUPPORT_PHONE' => $request->support_phone,
            'FACEBOOK_URL' => $request->facebook_url,
            'INSTAGRAM_URL' => $request->instagram_url,
            'TWITTER_URL' => $request->twitter_url,
            'YOUTUBE_URL' => $request->youtube_url,
            'LINKEDIN_URL' => $request->linkedin_url,
            'CURRENCY_POSITION' => $request->currency_position,
            'APP_NAME' => $request->app_name,
            'APP_DATE_TIME_FORMAT' => $request->app_date_time_format,
            'APP_DATE_FORMAT' => $dates['date'],
            'APP_TIME_FORMAT' => $dates['time'],
            'APP_TIMEZONE' => $request->app_timezone,
            'APP_SET_DEFAULT_LANGUAGE' => $request->app_defult_language,
            'APP_CURRENCY' => $request->app_currency,
            'APP_CURRENCY_SYMBOL' => explode(' - ', $currencies[$request->app_currency])[0]
        ];

        if ($request->has('app_dark_logo')) {
            $data['APP_DARK_SMALL_LOGO'] = 'uploads/' . uploadFile($request->app_dark_logo, 'logo');
        }

        if ($request->has('app_favicon_logo')) {
            $data['APP_FAVICON_ICON'] = 'uploads/' . uploadFile($request->app_favicon_logo, 'logo');
        }

        DotenvEditor::setKeys($data)->save();
        Artisan::call('config:clear');

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.environment.title')]));
        return redirect()->back();
    }

    public static function GetTimeZones()
    {
        return getTimezoneList();
    }

    public static function GetDateFormat()
    {
        $results = array_map(function ($element)
        {
            return $element['value'];
        }, self::$timeformate);
        return $results;
    }


    //Email Setting
    public function emailSetting()
    {
        return view('admin.settings.email');
    }

    public function emailSave()
    {
        $request = request();

        $lbl_app_smtp_host = strtolower(__('system.fields.app_smtp_host'));
        $lbl_app_smtp_username = strtolower(__('system.fields.app_smtp_username'));
        $lbl_app_smtp_port = strtolower(__('system.fields.app_smtp_port'));
        $lbl_app_smtp_password = strtolower(__('system.fields.app_smtp_password'));
        $lbl_app_smtp_encryption = strtolower(__('system.fields.app_smtp_encryption'));
        $lbl_app_smtp_from_address = strtolower(__('system.fields.app_smtp_from_address'));

        $request->validate(['app_smtp_host' => ['required', 'min:2'], 'app_smtp_username' => ['required', 'string', 'min:2'], 'app_smtp_password' => ['required', 'string', 'min:2'], 'app_smtp_from_address' => ['required', 'email', 'min:2']], [
            "app_smtp_host.required" => __('validation.required', ['attribute' => $lbl_app_smtp_host]),
            "app_smtp_host.string" => __('validation.custom.invalid', ['attribute' => $lbl_app_smtp_host]),
            "app_smtp_host.regex" => __('validation.custom.invalid', ['attribute' => $lbl_app_smtp_host]),

            "app_smtp_port.required" => __('validation.required', ['attribute' => $lbl_app_smtp_port]),
            "app_smtp_port.in" => __('validation.enum', ['attribute' => $lbl_app_smtp_port]),

            "app_smtp_encryption.required" => __('validation.required', ['attribute' => $lbl_app_smtp_encryption]),
            "app_smtp_encryption.in" => __('validation.enum', ['attribute' => $lbl_app_smtp_encryption]),

            "app_smtp_username.required" => __('validation.required', ['attribute' => $lbl_app_smtp_username]),
            "app_smtp_username.string" => __('validation.custom.invalid', ['attribute' => $lbl_app_smtp_username]),
            "app_smtp_username.min" => __('validation.custom.invalid', ['attribute' => $lbl_app_smtp_username]),

            "app_smtp_password.required" => __('validation.required', ['attribute' => $lbl_app_smtp_password]),
            "app_smtp_password.string" => __('validation.custom.invalid', ['attribute' => $lbl_app_smtp_password]),
            "app_smtp_password.min" => __('validation.custom.invalid', ['attribute' => $lbl_app_smtp_password]),

            "app_smtp_from_address.required" => __('validation.required', ['attribute' => $lbl_app_smtp_from_address]),
            "app_smtp_from_address.email" => __('validation.custom.invalid', ['attribute' => $lbl_app_smtp_from_address]),
            "app_smtp_from_address.min" => __('validation.custom.invalid', ['attribute' => $lbl_app_smtp_from_address])

        ]);

        $data = ['MAIL_HOST' => $request->app_smtp_host, 'MAIL_PORT' => $request->app_smtp_port, 'MAIL_USERNAME' => $request->app_smtp_username, 'MAIL_PASSWORD' => $request->app_smtp_password, 'MAIL_ENCRYPTION' => $request->app_smtp_encryption, 'MAIL_FROM_ADDRESS' => $request->app_smtp_from_address];

        DotenvEditor::setKeys($data)->save();
        Artisan::call('config:clear');

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.environment.title')]));
        return redirect()->back();
    }

    public function emailTest(Request $request)
    {
        $lbl_email = __('system.fields.email');

        $request->validate(['test_email' => ['required', 'email', 'min:2']], ["test_email.required" => __('validation.required', ['attribute' => $lbl_email]), "app_smtp_from_address.email" => __('validation.custom.invalid', ['attribute' => $lbl_email]), "app_smtp_from_address.min" => __('validation.custom.invalid', ['attribute' => $lbl_email])]);

        try {
            Mail::send(new TestMail($request->test_email));

            $request->session()->flash('Success', __('system.messages.test_email_success'));
            return redirect()->back();
        } catch (\Exception $exception) {
            $request->session()->flash('Error', $exception->getMessage());
            return redirect()->back();
        }
    }

    //Email Setting
    public function displaySetting()
    {
        return view('admin.settings.display');
    }

    public function displaySave()
    {
        $request = request();

        $request->validate(['display_language' => ['required'], 'dark_light_change' => ['required'], 'direction_change' => ['required'], 'show_banner' => ['required'], 'show_board_name' => ['required'],]);

        $data = ['DISPLAY_LANGUAGE' => $request->display_language, 'DARK_LIGHT_CHANGE' => $request->dark_light_change, 'DIRECTION_CHANGE' => $request->direction_change, 'SHOW_BANNER' => $request->show_banner, 'SHOW_BUSINESS_NAME' => $request->show_board_name,];

        DotenvEditor::setKeys($data)->save();
        Artisan::call('config:clear');

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.environment.title')]));
        return redirect()->back();
    }


    //Email Setting
    public function paymentShow()
    {
        return view('admin.settings.payment');
    }

    public function paymentUpdate(Request $request)
    {
        try {
            $input = $request->only(
                'stripe_publish_key',
                'stripe_mode',
                'stripe_currency_code',
                'gateway_type',
                'stripe_secret_key',
                'stripe_status',
                'paypal_client_id',
                'paypal_mode',
                'paypal_secret_key',
                'paypal_currency_code',
                'paypal_status',
                'instructions',
                'offline_status',
                'razorpay_currency_code',
                'razorpay_key_id',
                'razorpay_secret_key',
                'razorpay_mode',
                'razorpay_status'
            );

            if (isset($input['gateway_type']) && in_array($input['gateway_type'], array('stripe', 'paypal', 'paystack', 'razorpay', 'offline'))) {

                //Stripe Payment Save
                $stripe_data = [
                    'STRIPE_CURRENCY_CODE' => $input['stripe_currency_code'],
                    'STRIPE_PUBLISH_KEY' => $input['stripe_publish_key'],
                    'STRIPE_SECRET_KEY' => $input['stripe_secret_key'],
                    'STRIPE_MODE' => $input['stripe_mode'],
                    'STRIPE_STATUS' => $input['stripe_status'],
                ];
                DotenvEditor::setKeys($stripe_data)->save();


                //Save PayPal Details
                $paypal_data = [
                    'PAYPAL_CURRENCY_CODE' => $input['paypal_currency_code'],
                    'PAYPAL_CLIENT_ID' => $input['paypal_client_id'],
                    'PAYPAL_SECRET_KEY' => $input['paypal_secret_key'],
                    'PAYPAL_MODE' => $input['paypal_mode'],
                    'PAYPAL_STATUS' => $input['paypal_status'],
                ];

                DotenvEditor::setKeys($paypal_data)->save();


                //Save offline Details
                $offline_data = [
                    'OFFLINE_INSTRUCTIONS' => $input['instructions'],
                    'OFFLINE_STATUS' => $input['offline_status']
                ];

                DotenvEditor::setKeys($offline_data)->save();


                //Save razorpay Details
                $offline_data = [
                    'RAZORPAY_CURRENCY_CODE' => $input['razorpay_currency_code'],
                    'RAZORPAY_KEY_ID' => $input['razorpay_key_id'],
                    'RAZORPAY_SECRET_KEY' => $input['razorpay_secret_key'],
                    'RAZORPAY_MODE' => $input['razorpay_mode'],
                    'RAZORPAY_STATUS' => $input['razorpay_status'],
                ];
                DotenvEditor::setKeys($offline_data)->save();
                Artisan::call('config:clear');

                $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.payment_setting.payment_gateway')]));
                return redirect()->back();
            } else {
                $request->session()->flash('Error', __('system.messages.operation_rejected'));
                return redirect()->back();
            }

        } catch (\Illuminate\Database\QueryException $ex) {
            $request->session()->flash('Error', __('system.messages.operation_rejected'));
            return redirect()->back();
        }
    }

    public function frontend()
    {
        return view('admin.settings.frontend');
    }

    public function frontendImages(Request $request)
    {
        $request = request();

        $lbl_banner_image_one = strtolower(__('system.fields.banner_image_one'));
        $lbl_banner_image_two = strtolower(__('system.fields.banner_image_two'));

        $request->validate(['banner_image_one' => ['max:10000', "image", 'mimes:jpeg,png,jpg,gif,svg,webp'], 'banner_image_two' => ['max:10000', "image", 'mimes:jpeg,png,jpg,gif,svg,webp']], [
            "banner_image_one.max" => __('validation.gt.file', ['attribute' => $lbl_banner_image_one, 'value' => 10000]),
            "banner_image_one.image" => __('validation.enum', ['attribute' => $lbl_banner_image_one]),
            "banner_image_one.mimes" => __('validation.enum', ['attribute' => $lbl_banner_image_one]),

            "banner_image_two.max" => __('validation.gt.file', ['attribute' => $lbl_banner_image_two, 'value' => 10000]),
            "banner_image_two.image" => __('validation.enum', ['attribute' => $lbl_banner_image_two]),
            "banner_image_two.mimes" => __('validation.enum', ['attribute' => $lbl_banner_image_two]),
        ]);

        $data = null;
        if ($request->has('banner_image_one')) {
            $data['BANNER_IMAGE_ONE'] = 'uploads/' . uploadFile($request->banner_image_one, 'frontend_images');
        }
        if ($request->has('banner_image_two')) {
            $data['BANNER_IMAGE_TWO'] = 'uploads/' . uploadFile($request->banner_image_two, 'frontend_images');
        }

        if ($data) {
            DotenvEditor::setKeys($data)->save();
            Artisan::call('config:clear');
        }

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.environment.title')]));
        return redirect()->back();
    }

    public function seoSetting()
    {

        $seo_keyword_data = Settings::where('title', 'seo_keyword')->first();
        $seo_keyword = $seo_keyword_data->value ?? '';

        $seo_description_data = Settings::where('title', 'seo_description')->first();
        $seo_description = $seo_description_data->value ?? '';

        $analytics_code_data = Settings::where('title', 'analytics_code')->first();
        $analytics_code = $analytics_code_data->value ?? '';

        return view('admin.settings.seo', compact('seo_keyword', 'seo_description', 'analytics_code'));
    }

    public function seoSave()
    {
        $request = request();

        Settings::updateOrCreate(['title' => 'seo_keyword'], ['value' => $request->seo_keyword]);

        Settings::updateOrCreate(['title' => 'seo_description'], ['value' => $request->seo_description]);

        Settings::updateOrCreate(['title' => 'analytics_code'], ['value' => $request->analytics_code]);

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.environment.title')]));
        return redirect()->back();
    }



    public function showRecaptcha()
    {
        return view('admin.settings.recaptcha');
    }

    public function updateRecaptcha()
    {
        $request = request();
        $request->validate([
            'enable_recaptcha' => ['required'],
            'nocaptcha_secret' => ['required_if:enable_recaptcha,==,"1"'],
            'nocaptcha_sitekey' => ['required_if:enable_recaptcha,==,"1"']
        ]);


        $nocaptcha_secret = '';
        $nocaptcha_sitekey = '';

        if ($request->enable_recaptcha == 1) {
            $nocaptcha_secret = $request->nocaptcha_secret ?? '';
            $nocaptcha_sitekey = $request->nocaptcha_sitekey ?? '';
        }

        $data = [
            'NOCAPTCHA_SECRET' => $nocaptcha_secret,
            'NOCAPTCHA_SITEKEY' => $nocaptcha_sitekey,
            'ENABLE_CAPTCHA' => $request->enable_recaptcha,
            'ENABLE_CAPTCHA_ON_SUGGESTION' => ($request->enable_recaptcha == '1') ? $request->enable_captcha_on_suggestion : 0,
            'ENABLE_CAPTCHA_ON_COMMENTS' => ($request->enable_recaptcha == '1') ? $request->enable_captcha_on_comments : 0,
            'ENABLE_CAPTCHA_ON_CONTACT_US' => ($request->enable_recaptcha == '1') ? $request->enable_captcha_on_contact_us : 0,
            'ENABLE_CAPTCHA_ON_SUPPORT_REQUEST' => ($request->enable_recaptcha == '1') ? $request->enable_captcha_on_support_request : 0,
        ];

        DotenvEditor::setKeys($data)->save();
        Artisan::call('config:clear');

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.environment.title')]));
        return redirect()->back();
    }
}
