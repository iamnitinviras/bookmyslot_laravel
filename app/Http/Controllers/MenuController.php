<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Requests\FeedbackRequest;
use App\Mail\NewCommentMail;
use App\Mail\NewFeedbackMail;
use App\Models\Changelog;
use App\Models\Product;
use App\Models\Category;
use App\Models\Feedback;
use App\Models\FeedbackComments;
use App\Models\FeedbackVotes;
use App\Models\ProductFaq;
use App\Models\Questions;
use App\Models\Roadmap;
use Illuminate\Support\Facades\Mail;
use Response;

class MenuController extends Controller
{
    public function show(Product $product)
    {
        $search=trim(request()->search);
        if ($product == null) {
            return redirect('/');
        }
        $categories = Category::where('branch_id', $product->id)->where('status', 'active')->orderBy('sort_order', 'asc')->get();
        $questions=Questions::where('branch_id', $product->id)->where('status', 'published')->orderBy('id','desc')->get()->take(10);
        if ($search!=null){
            $questions=Questions::where('branch_id', $product->id)->where('status', 'published')->where(function ($query) use ($search){
                    $query->where('question','LIKE','%'.$search.'%')->orWhere('answer','LIKE','%'.$search.'%');
                })->orderBy('id','desc')->get();
            return view("theme.search_page", ['product' => $product,'questions'=>$questions]);
        }
        return view("theme.index", ['product' => $product, 'categories' => $categories,'questions'=>$questions]);
    }

    public function categories($product)
    {
        $productData = Branch::where('slug', $product)->first();
        if ($productData == null) {
            return redirect('/');
        }
        $categories = Category::where('branch_id', $productData->id)->where('status', 'active')->orderBy('sort_order', 'asc')->get();
        return view("theme.categories", ['product' => $productData, 'categories' => $categories]);
    }

    public function contact($product)
    {
        $productData = Branch::where('slug', $product)->first();
        if ($productData == null) {
            return redirect('/');
        }
        return view("theme.contact", ['product' => $productData]);
    }

    public function changelog($product)
    {
        $productData = Branch::where('slug', $product)->first();
        if ($productData == null) {
            return redirect('/');
        }
        if($productData->allow_changelog==false){
            return redirect(route('frontend.product',['product'=>$productData->slug]));
        }
        $changelogs=Changelog::where('branch_id',$productData->id)->orderBy('id','desc')->get();
        return view("theme.changelog", ['product' => $productData,'changelogs'=>$changelogs]);
    }

    public function featureRequest($product)
    {
        $productData = Branch::where('slug', $product)->first();
        if ($productData == null) {
            return redirect('/');
        }

        if (!$productData->allow_feature_request){
            return redirect(route('frontend.product',['product'=>$productData->slug]));
        }
        $changelogs=Changelog::where('branch_id',$productData->id)->orderBy('id','desc')->get();

        $roadmaps = Roadmap::where('branch_id', $productData->id)->where('status','active')
            ->orderByRaw('CASE WHEN is_default = 1 THEN 0 ELSE 1 END, sort_order')
            ->get();

        $roadmap = Roadmap::where('branch_id', $productData->id)->where('is_default', 1)->first();
        $feedbacks = Feedback::where('branch_id', $productData->id)->where('roadmap_id',$roadmap->id)->where('status','approved')->orderBy('id', 'desc')->get();

        return view("theme.feature_request.index", ['selected_roadmap'=>$roadmap->id??'','feedbacks'=>$feedbacks,'product' => $productData,'changelogs'=>$changelogs,'roadmaps'=>$roadmaps,'roadmap'=>$roadmap]);
    }

    public function feedbackByRoadmap($product, Roadmap $roadmap){
        $productData = Branch::where('slug', $product)->first();
        if ($productData == null) {
            return redirect('/');
        }

        if (!$productData->allow_feature_request){
            return redirect(route('frontend.product',['product'=>$productData->slug]));
        }

        $feedbacks = Feedback::where('branch_id', $productData->id)->where('roadmap_id',$roadmap->id)->where('status','approved')->orderBy('id', 'desc')->get();
        $roadmaps = Roadmap::where('branch_id', $productData->id)->where('status','active')
            ->orderByRaw('CASE WHEN is_default = 1 THEN 0 ELSE 1 END, sort_order')
            ->get();
        return view("theme.feature_request.index", ['product' => $productData,'selected_roadmap'=>$roadmap->id,'roadmaps'=>$roadmaps, 'feedbacks' => $feedbacks]);
    }

    protected function feedbackDetails($product, Feedback $feedback)
    {
        $ipAddress = request()->ip();
        $productData = Branch::where('slug', $product)->first();
        if ($productData == null) {
            return redirect('/');
        }
        $feedback->total_views++;
        $feedback->save();
        $feedback_vote=$feedback->ipVotes()->where('ip_address', $ipAddress)->first();
        return view("theme.feature_request.details", ['product' => $productData,'feedback_vote'=>$feedback_vote, 'feedback' => $feedback]);
    }

    public function createFeatureRequest($product)
    {
        $productData = Branch::where('slug', $product)->first();
        if ($productData == null) {
            return redirect('/');
        }
        return view("theme.feature_request.create", ['product' => $productData]);
    }
    public function feedbackSubmit($product, FeedbackRequest $request)
    {
        $productData = Branch::where('slug', $product)->first();
        if ($productData == null) {
            return redirect('/');
        }
        $roadmap = Roadmap::where('branch_id', $productData->id)->where('is_default', 1)->first();
        if ($roadmap == null) {
            return redirect()->back();
        }

        try {
            if ($productData->feedback_moderation){
                $status="pending";
                $success_message=trans('system.feature_requests.feedback_approval_message');
            }else{
                $status="approved";
                $success_message=trans('system.feature_requests.feedback_success_message');
            }

            $feedback_image=null;
            if ($request->file('image')!=null){
                $feedback_image=uploadFile($request->file('image'), 'feedback_image');
            }

            Feedback::create([
                'title' => $request->title,
                'description' => $request->description,
                'branch_id' => $productData->id,
                'roadmap_id' => $roadmap->id,
                'status' => $status,
                'category_id' => $request->category_id,
                'user_name' => $request->user_name,
                'user_email' => $request->user_email,
                'feedback_image'=>$feedback_image
            ]);

            $email=isset($productData->created_user)?$productData->created_user->email:null;
            if (isset($productData->created_user) && $productData->created_user!=null){
                $vendor_name=$productData->created_user->first_name;
                Mail::send(new NewFeedbackMail($vendor_name,$request->title,$request->description, $email,$productData->title));
            }

            return redirect(route('frontend.product.feature.request', ['product' => $productData->slug]))->with('Success',$success_message);
        }catch (\Exception $exception){
            return redirect(route('frontend.product.feature.request', ['product' => $productData->slug]));
        }
    }

    public function commentsSave(CommentRequest $request,$product,Feedback $feedback){
        $productData = Branch::where('slug', $product)->first();
        if ($productData == null) {
            return redirect('/');
        }

        try {

            if ($productData->comment_moderation){
                $status="pending";
                $success_message=trans('system.frontend.comment_approval_message');
            }else{
                $status="approved";
                $success_message=trans('system.frontend.comment_success_message');
            }
            FeedbackComments::create([
                'branch_id'=>$productData->id,
                'feedback_id'=>$feedback->id,
                'comments'=>$request->message,
                'user_name'=>$request->user_name,
                'status'=>$status,
            ]);

            $email=isset($productData->created_user)?$productData->created_user->email:null;
            if (isset($productData->created_user) && $productData->created_user!=null){
                $vendor_name=$productData->created_user->first_name;
                Mail::send(new NewCommentMail($vendor_name,$feedback->title,$request->message, $email,$productData->title));
            }

            return redirect(route('frontend.product.feature.request.details',['product'=>$productData->slug,'feedback'=>$feedback->id]))->with('Success',$success_message);

        }catch (\Exception $exception){
            return redirect(route('frontend.product.feature.request', ['product' => $productData->slug]))->with('Error',$exception->getMessage());
        }
    }

    public function faqs($product)
    {
        $productData = Branch::where('slug', $product)->first();
        if ($productData == null) {
            return redirect('/');
        }

        $faqs=ProductFaq::where('branch_id',$productData->id)->where('status','active')->orderBy('title','asc')->get();
        return view("theme.faqs", ['product' => $productData,'faqs'=>$faqs]);
    }

    public function categoryDetails($product, Category $category)
    {
        $productData = Branch::where('slug', $product)->first();
        if ($productData == null) {
            return redirect('/');
        }
        return view("theme.category_details", ['product' => $productData, 'category' => $category]);
    }

    public function article($product, Questions $article){
        $productData = Branch::where('slug', $product)->first();
        if ($productData == null) {
            return redirect('/');
        }
        return view("theme.article", ['product' => $productData, 'question' => $article]);
    }
}
