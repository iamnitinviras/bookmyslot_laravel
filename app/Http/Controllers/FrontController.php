<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Feedback;
use App\Models\FeedbackVotes;
use App\Models\User;
use App\Models\Plans;
use App\Models\CmsPage;
use App\Models\ContactUs;
use App\Mail\ContactUsMail;
use App\Models\FaqQuestion;
use App\Models\Testimonial;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ContactUsRequest;
use Response;

class   FrontController extends Controller
{
    public function index(Request $request)
    {
        $compact = [];
        $compact['testimonials'] = Testimonial::get();
        $compact['faqQuestions'] = FaqQuestion::get();
        $compact['plans'] = Plans::take(2)->get();
        return view("landing_page.index", $compact);
    }

    public function contact_us(Request $request)
    {
        return view('landing_page.contact_us');
    }

    public function reviews(Request $request)
    {
        $testimonials = Testimonial::all();
        return view('landing_page.reviews', compact('testimonials'));
    }

    public function pricing(Request $request)
    {
        $plans = Plans::take(2)->get();
        return view('landing_page.pricing', compact('plans'));
    }

    public function faqs(Request $request)
    {
        $faqs = FaqQuestion::all();
        return view('landing_page.faqs', compact('faqs'));
    }

    public function contactUs(ContactUsRequest $request)
    {
        ContactUs::create(['name' => $request->name, 'email' => $request->email, 'message' => $request->message]);

        $data = [];
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['message'] = $request->message;

        $adminEmails = User::where('user_type', User::USER_TYPE_ADMIN)->pluck('email')->toArray();

        foreach ($adminEmails as $adminEmail) {

            Mail::send(new ContactUsMail($data, $adminEmail));
        }
        return redirect('/contact-us')->with('Success', trans('system.contact_us.success'));
    }

    public function product($product_slug)
    {
        $hide_product_after_days = config('custom.hide_product_after_days');

        $product = Branch::where('slug', $product_slug)->first();

        if (empty($product)) {
            return redirect('/');
        }

        if ($product->created_user == null) {
            return redirect('/');
        }

        $current_plans = $product->created_user->active_plan;

        if ($product->created_user->free_forever == 0) {

            if (isset($current_plans) && $current_plans != null) {

                if ($current_plans->type != "onetime") {

                    if (isset($current_plans->expiry_date)) {
                        $current_date = Carbon::now()->format('Y-m-d H:i:s');

                        $expire_date = $current_plans->expiry_date;

                        if ($expire_date < $current_date) {

                            $current_date = Carbon::parse($current_date);
                            $shift_difference = $current_date->diffInDays($expire_date);

                            if ($shift_difference > $hide_product_after_days) {
                                return redirect(config('app.url'));
                            }
                        }
                    }
                }

            } else {
                return redirect('/');
            }

        }

        return (new \App\Http\Controllers\MenuController)->show($product);
    }

    public function termsAndCondition()
    {
        $termsAndCondition = CmsPage::where('slug', 'terms-and-conditions')->first();
        return view('landing_page.terms_and_condition')->with('termsAndCondition', $termsAndCondition);
    }

    public function privacyPolicy()
    {
        $privacyPolicy = CmsPage::where('slug', 'privacy-policy')->first();
        return view('landing_page.privacy_policy')->with('privacyPolicy', $privacyPolicy);
    }


    public function upvote(Feedback $feedback)
    {
        $ipAddress = request()->ip();
        $feedback_vote = $feedback->ipVotes()->where('ip_address', $ipAddress)->first();

        if ($feedback_vote == null) {
            $feedback->total_likes++;
            $feedback->save();
            FeedbackVotes::create(['ip_address' => $ipAddress, 'feedback_id' => $feedback->id, 'vote_type' => 'upvote']);
        } else {
            if ($feedback_vote->vote_type == 'downvote') {

                $feedback->total_dislikes--;
                $feedback->total_likes++;
                $feedback->save();
                FeedbackVotes::where('ip_address', $ipAddress)->where('feedback_id', $feedback->id)->update(['vote_type' => 'upvote']);

            } else {
                $feedback->total_likes--;
                $feedback->save();
                FeedbackVotes::where('ip_address', $ipAddress)->where('feedback_id', $feedback->id)->delete();
            }

        }

        return Response::json(array('total_likes' => $feedback->total_likes, 'total_dislikes' => $feedback->total_dislikes));
    }

    public function downvote(Feedback $feedback)
    {
        $ipAddress = request()->ip();
        $feedback_vote = $feedback->ipVotes()->where('ip_address', $ipAddress)->first();

        if ($feedback_vote == null) {
            $feedback->total_dislikes++;
            $feedback->save();
            FeedbackVotes::create(['ip_address' => $ipAddress, 'feedback_id' => $feedback->id, 'vote_type' => 'downvote']);
        } else {
            if ($feedback_vote->vote_type == 'upvote') {

                $feedback->total_dislikes++;
                $feedback->total_likes--;
                $feedback->save();
                FeedbackVotes::where('ip_address', $ipAddress)->where('feedback_id', $feedback->id)->update(['vote_type' => 'downvote']);

            } else {
                $feedback->total_dislikes--;
                $feedback->save();
                FeedbackVotes::where('ip_address', $ipAddress)->where('feedback_id', $feedback->id)->delete();
            }
        }

        return Response::json(array('total_likes' => $feedback->total_likes, 'total_dislikes' => $feedback->total_dislikes));

    }
}
