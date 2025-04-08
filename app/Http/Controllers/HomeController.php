<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\ContactUs;
use App\Models\Gym;
use App\Models\MemberEnquiry;
use App\Models\Members;
use App\Models\MembersAttendance;
use App\Models\PendingPayments;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\Subscriptions;
use App\Repositories\UserRepository;
use Response;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }
    public function __construct()
    {

        $this->middleware('auth');
    }

    public function editorImageUpload(Request $request)
    {
        $imgpath = request()->file('file')->store('uploads', 'public');
        return Response::json(['location' => $imgpath]);
    }

    public function verifyEmail()
    {
        $user = auth()->user();
        if ($user->user_type !== User::USER_TYPE_VENDOR) {
            return redirect('home');
        }
        if ($user->email_verified_at != null) {
            return redirect('home');
        }
        return view('auth.verify', compact('user'));
    }

    public function index()
    {
        $user = auth()->user();
        $branch = $user->branch;
        $today=date('Y-m-d');
        $params = [];

        if ($user->user_type == User::USER_TYPE_STAFF) {
            $created_by = $user->created_by;
        } elseif ($user->user_type == User::USER_TYPE_VENDOR) {
            $created_by = $user->id;
        }

        $count['payment_setting_count'] = Settings::whereIn('title', ['stripe', 'offline'])->count();
        $count['vendors_count'] = (new UserRepository())->getOwnersQuery([])->count();

        if (!$user->hasRole('Super-Admin')) {

            $total_branch_count = Branch::where('user_id', $created_by)->count();
            $total_gyn_count = Gym::where('user_id', $created_by)->count();
            if ($total_gyn_count==0){
                return redirect()->route('admin.gym.index');
            }
            if ($total_branch_count == 0) {
                return redirect()->route('admin.branch.create');
            }

            $branch_id = isset($branch->id) ? $branch->id : 0;

            $joined_today=Members::where('branch_id',$branch_id)->where('join_date',$today)->count();
            $total_members=Members::where('branch_id',$branch_id)->count();
            $present_member=MembersAttendance::where('branch_id',$branch_id)->where('attendance_date',$today)->count();

            $absent_member = Members::whereNotIn('id', function ($query) use ($today) {
                $query->select('member_pk_id')
                    ->from('members_attendances')
                    ->whereDate('attendance_date', $today);
            })->where('branch_id', $branch_id)->count();

            $pending_payments=PendingPayments::with(['member','package'])->where('branch_id',$branch_id)->where('status','pending')->get();
            $follow_up_today=MemberEnquiry::where('branch_id',$branch_id)->where('next_follow_up_date',$today)->get();

            $count['pending_payments'] = $pending_payments;
            $count['total_members'] = $total_members;
            $count['today_joined_member'] = $joined_today;
            $count['branches_count'] = $total_branch_count;
            $count['present_member'] = $present_member;
            $count['absent_member'] = $absent_member;
            $count['follow_up_today'] = $follow_up_today;

//            $count['roadmap_report_list'] =  Branch::select('roadmaps.title as name', DB::raw('COUNT(feedbacks.roadmap_id) as y'))
//                ->get();
//
//
//            $currentYear = now()->year;
//
//            $monthNames = [
//                1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
//                5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
//                9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
//            ];
//
//            $feedbackCounts = Branch::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
//                ->whereYear('created_at', $currentYear)
//                ->groupBy('month')
//                ->get();
//
//            $monthlyFeedbackChartData=array();
//            $monthlyCounts = [];
//            foreach ($feedbackCounts as $mcount) {
//                $month = $mcount->month;
//                $total = $mcount->total;
//                $monthName = $monthNames[$month];
//                $monthlyCounts[$monthName] = $total;
//                $monthlyFeedbackChartData[]=array(
//                    'name'=>$monthName,
//                    'month'=>$month,
//                    'y'=>$total
//                );
//            }
//
//            // Fill in missing months with zero counts
//            for ($month = 1; $month <= 12; $month++) {
//                $monthName = $monthNames[$month];
//                if (!isset($monthlyCounts[$monthName])) {
//                    $monthlyCounts[$monthName] = 0;
//                    $monthlyFeedbackChartData[]=array(
//                        'name'=>$monthName,
//                        'month'=>$month,
//                        'y'=>0
//                    );
//                }
//            }
//
//            usort($monthlyFeedbackChartData, function($a, $b) {
//                return $a['month'] - $b['month'];
//            });
//
//            $monthlyFeedbackChartData = array_map(function($item) {
//                unset($item['month']);
//                return $item;
//            }, $monthlyFeedbackChartData);
//
//            $count['monthlyCounts'] =$monthlyFeedbackChartData;
        } else {

            $count['branches_count'] = 0;
            $count['users_count'] = User::where('user_type', User::USER_TYPE_STAFF)->count();
            $count['subscriptions'] = Subscriptions::orderBy('created_at', 'desc')->where('status', "pending")->with(['user' => function ($thisUser) {
                    $thisUser->select('id', 'first_name', 'last_name', 'profile_image', 'email');
                }, 'plan'])->select('id', 'user_id', 'plan_id', 'amount')->get();
            $count['pending_subscriptions'] = count($count['subscriptions']);
        }

        return view('home', $count);
    }

    public static function getCurrentUsersAllBranch()
    {
        $user = auth()->user();
        $user_id = 0;
        $assigned_branch = array();
        if ($user->user_type == User::USER_TYPE_STAFF) {
            $user_id = $user->created_by;
            $assigned_branch = $user->assigned_branch->pluck('branch_id')->toArray();
        } elseif ($user->user_type == User::USER_TYPE_VENDOR) {
            $user_id = $user->id;
        }

        return Branch::where('user_id', $user_id)->where(function ($query) use ($assigned_branch, $user) {
            if ($user->user_type == User::USER_TYPE_STAFF) {
                $query->whereIn('id', $assigned_branch);
            }
        })->select('id', 'title')->get();
    }

    public function getRightBarContent(Request $request)
    {
        $action = $request->action;
        $id = (int)$request->id;
        if ($action == 'contact-us') {
            $contact_data = ContactUs::find($id);
            return view('admin.contact_us.sidebar', compact('contact_data'))->render();
        }

        if ($action == 'testimonials') {
            $testimonial = Testimonial::find($id);
            return view('admin.testimonial.sidebar', compact('testimonial'))->render();
        }

        if ($action == 'subscription-history') {
            $subscription = Subscriptions::where('id', $id)->with('plan')->first();
            return view('admin.vendors.sidebar', compact('subscription'))->render();
        }
    }
}
