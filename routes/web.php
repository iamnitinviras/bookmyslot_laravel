<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
//$host = request()->getHost();
$appUrl = config('app.url');
$parsedUrl = parse_url($appUrl);
$host = $parsedUrl['host'];



Route::middleware(['front_setting_middleware'])->group(function ()
{
    Route::get('/', [\App\Http\Controllers\FrontController::class, 'index'])->name('/');
    Route::get('/contact-us', [\App\Http\Controllers\FrontController::class, 'contact_us'])->name('frontend.contact_us');
    Route::post('/contact-us', [\App\Http\Controllers\FrontController::class, 'contactUs'])->name('contactUs');
    Route::get('/contact-us', [\App\Http\Controllers\FrontController::class, 'contact_us'])->name('frontend.contact_us');
    Route::get('/pricing', [\App\Http\Controllers\FrontController::class, 'pricing'])->name('frontend.pricing');
    Route::get('/faq', [\App\Http\Controllers\FrontController::class, 'faqs'])->name('frontend.faqs');
    Route::get('/reviews', [\App\Http\Controllers\FrontController::class, 'reviews'])->name('frontend.reviews');
    Route::get('/terms-and-condition', [\App\Http\Controllers\FrontController::class, 'termsAndCondition'])->name('terms-and-condition');
    Route::get('/privacy-policy', [\App\Http\Controllers\FrontController::class, 'privacyPolicy'])->name('privacy-policy');
    Route::get('/refund-policy', [\App\Http\Controllers\FrontController::class, 'refundPolicy'])->name('refund-policy');
    Route::post('/feedback/{feedback}/upvote', [\App\Http\Controllers\FrontController::class, 'upvote'])->name('feedback.upvote');
    Route::post('/feedback/{feedback}/downvote', [\App\Http\Controllers\FrontController::class, 'downvote'])->name('feedback.downvote');
});

Route::middleware(['preventBackHistory'])->group(function ()
{

    Auth::routes(['verify' => true]);
    Route::post('slug-available-check', [\App\Http\Controllers\Auth\RegisterController::class, 'slugCheck'])->name('slug.check');
    Route::put('default/{language}/languages', [App\Http\Controllers\Admin\LanguageController::class, 'defaultLanguage'])->name('admin.default.language');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['auth', 'default_product_exists']);
    Route::get('/verify-email', [App\Http\Controllers\HomeController::class, 'verifyEmail'])->name('verifyEmail')->middleware(['auth']);
    Route::post('/editor/image-upload', [App\Http\Controllers\HomeController::class, 'editorImageUpload']);
    Route::post('theme_mode', [App\Http\Controllers\Controller::class, 'themeMode'])->name('theme.mode');
    Route::get('staff/plan', [App\Http\Controllers\Admin\VendorController::class, 'staffPlan']);
    Route::group(['middleware' => ["auth", "default_product_exists"], 'as' => "admin."], function ()
    {
        //Vendor Module
        Route::group(['middleware' => ['role:vendor|staff', 'vendor_settings']], function ()
        {
            // vendor management
            Route::resource('staff', App\Http\Controllers\Admin\StaffController::class);

            Route::resource('expenses', App\Http\Controllers\Admin\ExpenseController::class);
            Route::resource('expense-categories', App\Http\Controllers\Admin\ExpenseCategoryController::class);

            Route::resource('branch', App\Http\Controllers\Admin\BranchController::class)->withoutMiddleware('vendor_settings');
            Route::resource('packages', App\Http\Controllers\Admin\PackageController::class);
            Route::resource('staffs', App\Http\Controllers\Admin\StaffController::class);
            Route::resource('members', App\Http\Controllers\Admin\MemberController::class);
            Route::resource('member-enquiry', App\Http\Controllers\Admin\MemberEnquiryController::class);
            Route::resource('member-trial', App\Http\Controllers\Admin\MemberTrialController::class);
            Route::resource('gym', App\Http\Controllers\Admin\GymController::class)->withoutMiddleware('vendor_settings');
            Route::get('get-package', [App\Http\Controllers\Admin\MemberController::class, 'package'])->name('single.package');

            //Collect Payment
            Route::get('payment/history', [App\Http\Controllers\Admin\MemberController::class, 'paymentHistory'])->name('payment.history');
            Route::get('payment/pending', [App\Http\Controllers\Admin\MemberController::class, 'pendingPayment'])->name('pending.payment');
            Route::get('payment/collect/{payment}', [App\Http\Controllers\Admin\MemberController::class, 'collectPayment'])->name('collect.payment');
            Route::put('payment/collect/{payment}', [App\Http\Controllers\Admin\MemberController::class, 'submitPartPayment'])->name('submit.part.payment');

            Route::get('attendance', [App\Http\Controllers\Admin\MemberController::class, 'attendance'])->name('attendance');
            Route::post('attendance/{member}', [App\Http\Controllers\Admin\MemberController::class, 'attendance_save'])->name('submit.attendance');
        });


        //Admin Modules
        Route::resource('posts', App\Http\Controllers\Admin\BlogController::class)->middleware('role:Super-Admin');
        Route::resource('blog-categories', App\Http\Controllers\Admin\BlogCategoryController::class)->middleware('role:Super-Admin');
        Route::resource('plans', App\Http\Controllers\Admin\PlanController::class)->middleware('role:Super-Admin');
        Route::resource('testimonials', App\Http\Controllers\Admin\TestimonialController::class)->middleware('role:Super-Admin');
        Route::resource('faqs', App\Http\Controllers\Admin\FaqQuestionController::class)->middleware('role:Super-Admin');
        Route::resource('cms-page', App\Http\Controllers\Admin\CmsPageController::class)->middleware('role:Super-Admin');
        Route::resource('contact-request', App\Http\Controllers\Admin\ContactUsController::class)->middleware('role:Super-Admin');
        Route::resource('vendors', App\Http\Controllers\Admin\VendorController::class)->middleware('role:Super-Admin');

        //Manage Language
        Route::resource('languages', App\Http\Controllers\Admin\LanguageController::class, ['except' => ['show'], 'middleware' => 'role:Super-Admin']);



        Route::post('global-search', [App\Http\Controllers\HomeController::class, 'globalSearch'])->name('global.search');
        Route::get('get-rightbar-content', [App\Http\Controllers\HomeController::class, 'getRightBarContent'])->name('getRightBarContent');

        //  Profile
        Route::controller(App\Http\Controllers\Admin\ProfileController::class)->group(function ()
        {
            // profile
            Route::get('webhook-data', 'webhookData')->name('webhookData')->withoutMiddleware(['default_product_exists']);
            Route::get('webhook-data/{webhook}', 'webhookDetails')->name('webhookDetails')->withoutMiddleware(['default_product_exists']);
            Route::get('profile', 'show')->name('profile')->withoutMiddleware(['default_product_exists']);
            Route::get('profile/edit', 'edit')->name('profile.edit')->withoutMiddleware(['default_product_exists']);
            Route::post('profile/delete', 'delete')->name('profile.account.delete')->withoutMiddleware(['default_product_exists'])->middleware('role:vendor|staff');
            Route::put('profile/update', 'update')->name('profile.update')->withoutMiddleware(['default_product_exists']);

            // password
            Route::get('profile/change-password', 'passwordEdit')->name('password.edit')->withoutMiddleware(['default_product_exists']);
            Route::put('profile/password/update', 'passwordUpdate')->name('password.update')->withoutMiddleware(['default_product_exists']);
        });

        Route::get('vendor/sign-out', [App\Http\Controllers\Admin\VendorController::class, 'vendorLogout'])->name('vendors.vendorLogout')->middleware('role:vendor')->withoutMiddleware(['default_product_exists']);
        Route::get('report', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('report')->middleware('role:Super-Admin');
        Route::get('sales-report', [App\Http\Controllers\Admin\ReportController::class, 'sales_report'])->name('sales.report')->middleware('permission:show sales_report');
        Route::get('attendance-report', [App\Http\Controllers\Admin\ReportController::class, 'attendance_report'])->name('attendance.report')->middleware('permission:show attendance_report');
        Route::get('expiry-report', [App\Http\Controllers\Admin\ReportController::class, 'expiry_report'])->name('expiry.report')->middleware('permission:show expiry_report');
        Route::get('collection-report', [App\Http\Controllers\Admin\ReportController::class, 'collection_report'])->name('collection.report')->middleware('permission:show collection_report');
        Route::get('balance-report', [App\Http\Controllers\Admin\ReportController::class, 'balance_report'])->name('balance.report')->middleware('permission:show balance_report');
        Route::get('pending-report', [App\Http\Controllers\Admin\ReportController::class, 'pending_payments'])->name('pending.report')->middleware('permission:show pending_payments');

        Route::group(['prefix' => 'vendors', 'controller' => App\Http\Controllers\Admin\VendorController::class, 'middleware' => 'role:Super-Admin'], function ()
        {
            Route::post('admin/subscription/cancel/{subscription}', 'subscriptionCancel')->name('subscription.cancel.admin');
            Route::get('{vendor}/sign-in', 'vendorSignin')->name('vendors.vendorSignin');
            Route::get('{vendor}/payment-history', 'paymentTransactions')->name('vendors.paymentTransactions');
            Route::get('{vendor}/change-plan', 'changePlan')->name('vendors.changePlan');
            Route::post('{vendor}/change-plan', 'updatePlan')->name('vendors.updatePlan.submit');
            Route::get('{vendor}/subscription-history', 'subscriptionHistory')->name('vendors.subscriptionHistory');
        });

        Route::post('vendors/update-password/{vendor}', [App\Http\Controllers\Admin\VendorController::class, 'updatePassword'])->middleware('role:Super-Admin')->name('vendors.password.update');
        Route::post('vendors/inactive/{vendor}', [App\Http\Controllers\Admin\VendorController::class, 'makeInactive'])->middleware('role:Super-Admin')->name('vendors.make.inactive');
        Route::post('vendors/active/{vendor}', [App\Http\Controllers\Admin\VendorController::class, 'makeActive'])->middleware('role:Super-Admin')->name('vendors.make.active');
        Route::post('vendors/verify-email/{vendor}', [App\Http\Controllers\Admin\VendorController::class, 'verifyEmail'])->middleware('role:Super-Admin')->name('vendors.verify.email');
        Route::post('staff/update-password/{staff}', [App\Http\Controllers\Admin\StaffController::class, 'updatePassword'])->middleware('role:vendor|staff')->name('staff.password.update');

        Route::post('trail/store', [App\Http\Controllers\Admin\PlanController::class, 'trailDetails'])->middleware('role:Super-Admin')->name('trailDetails.store');

        Route::get('qr', [App\Http\Controllers\Admin\BranchController::class, 'createQR'])->name('create.QR')->middleware('permission:show qrcode');
        Route::post('{product}/genarteQR', [App\Http\Controllers\Admin\BranchController::class, 'genarteQR'])->name('genarteQR')->middleware('permission:show qrcode');

        // set current(default)
        Route::put('default/{branch}/branchs', [App\Http\Controllers\Admin\BranchController::class, 'defaultBranch'])->name('default.branch');


        //Super Admin Role Permission
        Route::get('subscription/transactions', [App\Http\Controllers\Admin\SubscriptionController::class, 'transactions'])->name('transactions')->middleware('role:Super-Admin');
        Route::group(['middleware' => ['role:Super-Admin']], function ()
        {

            Route::group(['prefix' => 'subscriptions', 'controller' => App\Http\Controllers\Admin\SubscriptionController::class, 'middleware' => 'role:Super-Admin', 'as' => 'subscriptions'], function ()
            {
                Route::get('/', 'subscriptions');
                Route::put('/approve/{subscription}', 'approve')->name('.approve');
                Route::put('/reject/{subscription}', 'reject')->name('.reject');
                Route::put('/pending/{subscription}', 'pending')->name('.pending');
                Route::put('/delete/{subscription}', 'delete')->name('.delete');
            });


            Route::controller(App\Http\Controllers\Admin\EnvSettingController::class)->group(function ()
            {
                Route::get('setting', 'index')->name('environment.setting');
                Route::get('setting/application', 'application_show')->name('environment.application.setting');
                Route::put('environment/setting', 'update')->name('environment.setting.update');

                Route::get('setting/recaptcha', 'showRecaptcha')->name('environment.recaptcha');
                Route::put('environment/setting/recaptcha', 'updateRecaptcha')->name('environment.recaptcha.update');

                //Display Setting
                Route::get('setting/display', 'displaySetting')->name('environment.setting.display');
                Route::put('environment/setting/display/save', 'displaySave')->name('environment.setting.display.update');

                //Email Setting
                Route::get('setting/email', 'emailSetting')->name('environment.setting.email');
                Route::put('environment/setting/email/save', 'emailSave')->name('environment.setting.email.update');
                Route::put('environment/setting/email/test', 'emailTest')->name('environment.setting.email.test');

                //SEO Setting
                Route::get('setting/seo', 'seoSetting')->name('environment.setting.seo');
                Route::put('environment/setting/seo/save', 'seoSave')->name('environment.setting.seo.update');

                //preferred Setting
                Route::get('setting/preferred', 'preferredSetting')->name('environment.setting.preferred');
                Route::put('environment/setting/preferred/save', 'preferredSave')->name('environment.setting.preferred.update');

                //social Setting
                Route::get('setting/social', 'socialSetting')->name('environment.setting.social');
                Route::put('environment/setting/social/save', 'socialSave')->name('environment.setting.social.update');

                //Analytics code
                Route::get('setting/analytics', 'analyticsSetting')->name('environment.setting.analytics');
                Route::put('environment/setting/analytics/save', 'analyticsSave')->name('environment.setting.analytics.update');

                //Payment setting
                Route::get('setting/payment', 'paymentShow')->name('environment.payment');
                Route::put('environment/setting/payment', 'paymentUpdate')->name('environment.payment.update');

                //Frontend Setting
                Route::get('setting/frontend', 'frontend')->name('environment.frontend');
                Route::put('environment/setting/frontend-images', 'frontendImages')->name('environment.frontend.images');
            });
        });

        //Vendor Setting
        Route::controller(App\Http\Controllers\Admin\VendorController::class)->group(function ()
        {
            Route::get('vendor/support', 'support')->name('vendor.support')->withoutMiddleware(['default_product_exists']);

            Route::group(['middleware' => 'vendor_settings'], function ()
            {
                Route::get('vendor/setting', 'setting')->name('vendor.setting');
                Route::put('vendor/setting', 'settingUpdate')->name('vendor.setting.update');

                Route::get('vendor/pusher-setting', 'pusherSetting')->name('vendor.pusher');
                Route::put('vendor/pusher-setting-update', 'pusherUpdate')->name('vendor.pusher.update');
            });
        })->middleware('role:vendor')->withoutMiddleware(['default_product_exists']);

        Route::controller(App\Http\Controllers\Admin\Payment\PaymentController::class)->group(function ()
        {
            Route::get('subscription', 'subscription')->name('vendor.subscription')->withoutMiddleware(['default_product_exists']);
            Route::get('transactions', 'paymentHistory')->name('vendor.payment.history')->withoutMiddleware(['default_product_exists']);

            Route::post('vendor/subscription/cancel/{subscription}', 'subscriptionCancel')->name('vendor.subscription.cancel')->withoutMiddleware(['default_product_exists']);
            Route::get('vendor/subscription/manage/{subscription}', 'subscriptionManage')->name('vendor.subscription.manage')->withoutMiddleware(['default_product_exists']);
            Route::get('subscription/plan/{plan}', 'planDetails')->name('vendor.plan.details')->withoutMiddleware(['default_product_exists']);
            Route::post('subscription/plan/{plan}', 'process')->name('vendor.plan.payment')->withoutMiddleware(['default_product_exists']);

        })->middleware('role:vendor');

        //Paypal Payment and Subscription
        Route::get('/paypal/onetime-success', [\App\Http\Controllers\Admin\Payment\PayPalController::class, 'onetimeSuccess'])->name('paypal.onetime.success')->withoutMiddleware(['default_product_exists']);
        Route::get('/paypal/onetime-cancelled', [\App\Http\Controllers\Admin\Payment\PayPalController::class, 'onetimeCancelled'])->name('paypal.onetime.cancel')->withoutMiddleware(['default_product_exists']);
        Route::get('/paypal/success', [\App\Http\Controllers\Admin\Payment\PayPalController::class, 'success'])->name('paypal.success')->withoutMiddleware(['default_product_exists']);
        Route::get('/paypal/cancel', [\App\Http\Controllers\Admin\Payment\PayPalController::class, 'cancel'])->name('paypal.cancel')->withoutMiddleware(['default_product_exists']);

        //Stripe subscription success & cancel
        Route::get('/stripe/success', [\App\Http\Controllers\Admin\Payment\StripeController::class, 'processSuccess'])->withoutMiddleware(['default_product_exists']);
        Route::get('/stripe/cancelled', [\App\Http\Controllers\Admin\Payment\StripeController::class, 'processCancelled'])->withoutMiddleware(['default_product_exists']);

        //Stripe onetime success & cancel
        Route::get('/stripe/onetime-success', [\App\Http\Controllers\Admin\Payment\StripeController::class, 'onetimeSuccess'])->withoutMiddleware(['default_product_exists']);
        Route::get('/stripe/onetime-cancelled', [\App\Http\Controllers\Admin\Payment\StripeController::class, 'onetimeCancelled'])->withoutMiddleware(['default_product_exists']);

        //Razorpay Payment and Subscription
        Route::get('/razor-pay/create-subscription', [\App\Http\Controllers\Admin\Payment\RazorpayController::class, 'process_subscription'])->name('razorpay.subscription.success')->withoutMiddleware(['default_product_exists']);
        Route::get('/razor-pay/onetime-success', [\App\Http\Controllers\Admin\Payment\RazorpayController::class, 'onetimeSuccess'])->name('razorpay.onetime.success')->withoutMiddleware(['default_product_exists']);
        Route::get('/razor-pay/onetime-cancelled', [\App\Http\Controllers\Admin\Payment\RazorpayController::class, 'onetimeCancelled'])->name('razorpay.onetime.cancel')->withoutMiddleware(['default_product_exists']);
        Route::get('/razor-pay/success', [\App\Http\Controllers\Admin\Payment\RazorpayController::class, 'success'])->name('razorpay.success')->withoutMiddleware(['default_product_exists']);
        Route::get('/razor-pay/cancel', [\App\Http\Controllers\Admin\Payment\RazorpayController::class, 'cancel'])->name('razorpay.cancel')->withoutMiddleware(['default_product_exists']);
    });
});


//Webhook Routes
Route::post('/webhook/stripe', [\App\Http\Controllers\Webhook\StripeWebhookController::class, 'index'])->withoutMiddleware(['default_product_exists']);
Route::post('/webhook/paypal', [\App\Http\Controllers\Webhook\PayPalWebhookController::class, 'index'])->withoutMiddleware(['default_product_exists']);
Route::post('/webhook/razorpay', [\App\Http\Controllers\Webhook\RazorpayController::class, 'index'])->withoutMiddleware(['default_product_exists']);

Auth::routes();

// Social Login
Route::get('login/{provider}', [\App\Http\Controllers\Auth\LoginController::class, 'redirectToProvider']);
Route::get('login/{provider}/callback', [\App\Http\Controllers\Auth\LoginController::class, 'handleProviderCallback']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
