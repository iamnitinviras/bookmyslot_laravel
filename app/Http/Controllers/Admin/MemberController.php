<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;
use App\Models\MemberPayment;
use App\Models\Members;
use App\Models\MembersAttendance;
use App\Models\Package;
use App\Models\PendingPayments;
use App\Repositories\MemberRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;

class MemberController extends Controller
{
    public static function middleware(): array
    {
        return [
            'permission:show members' => ['only' => ['index', 'show']],
            'permission:add members' => ['only' => ['create', 'store']],
            'permission:edit members' => ['only' => ['edit', 'update']],
            'permission:delete members' => ['only' => ['destroy']],
        ];
    }

    public function index()
    {
        $request = request();
        $user = auth()->user();
        $params = $request->only('par_page', 'sort', 'direction', 'filter');
        $par_page = config('custom.per_page');
        if (in_array($request->par_page, [10, 25, 50, 100])) {
            $par_page = $request->par_page;
        }

        $params['par_page'] = $par_page;
        $params['branch_id'] = auth()->user()->branch_id;
        $params['user_id'] = $user->id;

        $members = (new MemberRepository())->getAllMember($params);

        return view('admin.members.index', ['members' => $members]);
    }

    public function create()
    {
        $branch_id = auth()->user()->branch_id;
        $packages = (new MemberRepository())->getAllActivePackage($branch_id);
        return view('admin.members.create', compact('packages'));
    }


    public function package(Request $request)
    {
        $package = Package::find($request->id);
        $number_of_months = 0;
        $package_end_date = null;
        if ($package != null) {
            $package_end_date = date('Y-m-d', strtotime('+' . $package->number_of_months . ' months'));
        }
        return Response::json(array('price' => $package->price ?? 0, 'package_end_date' => $package_end_date));
    }

    public function collectPayment(Request $request, PendingPayments $payment){
        $branch_id = auth()->user()->branch_id;
        $pending_payment=PendingPayments::with(['member','package'])
            ->where('id',$payment->id)
            ->where('branch_id',$branch_id)
            ->where('status','pending')
            ->first();

        if ($pending_payment==null){
            return redirect(route('admin.pending.payment'));
        }
        return view('admin.members.collect_payment', compact('pending_payment'));
    }

    public function submitPartPayment(Request $request, PendingPayments $payment){
        $new_remaining_balance = $payment->due_amount - $request->amount_paid;
        $user = auth()->user();

        MemberPayment::create([
            'branch_id' => $payment->branch_id,
            'member_pk_id' => $payment->member_pk_id,
            'package_id' => $payment->package_id,
            'amount_paid' => $request->amount_paid,
            'package_price' => $payment->due_amount,
            'payment_type' => $new_remaining_balance > 0 ? 'partial' : 'full',
            'due_amount' => $new_remaining_balance,
            'discount' =>0,
            'payment_mode' => $request->payment_mode,
            'created_by' => $user->id,
            'payment_date' => date('Y-m-d'),
            'bill_date' =>date('Y-m-d'),
            'activation_date' => date('Y-m-d'),
        ]);

        if ($new_remaining_balance > 0) {
            $payment->due_amount=$new_remaining_balance;
            $payment->updated_at=date('Y-m-d H:i:s');
            $payment->save();
        }else{
            $payment->due_amount=$new_remaining_balance;
            $payment->status='paid';
            $payment->updated_at=date('Y-m-d H:i:s');
            $payment->save();
        }

        $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.fields.collect_payment')]));
        return redirect(route('admin.pending.payment'));
    }

    public function pendingPayment(Request $request){
        $branch_id = auth()->user()->branch_id;
        $pending_payments=PendingPayments::with(['member','package'])->where('branch_id',$branch_id)->where('status','pending')->get();
        return view('admin.members.pending_payment', compact('pending_payments'));
    }

    public function paymentHistory(Request $request){
        $branch_id = auth()->user()->branch_id;
        $payment_history=MemberPayment::with(['package','member'])->where('branch_id',$branch_id)->orderBy('id','desc')->get();
        return view('admin.members.payment_history', compact('payment_history'));
    }

    public function store(MemberRequest $request)
    {
        try {
            $user = auth()->user();

            $package = Package::find($request->select_package);

            if ($package == null) {
                return redirect(route('admin.members.index'));
            }

            $package_end_date = date('Y-m-d', strtotime('+' . $package->number_of_months . ' months'));
            $gym_customer_id = Members::where('branch_id', $request->branch_id)->max('gym_customer_id') + 1;

            $new_remaining_balance = $package->price - $request->amount_paid-$request->discount??0;

            $member = Members::create([
                'branch_id' => $request->branch_id,
                'gym_customer_id' => $gym_customer_id,
                'name' => $request->name,
                'gender' => $request->gender,
                'email' => $request->email,
                'address' => $request->address,
                'weight' => $request->weight,
                'height' => $request->height,
                'created_by' => $user->id,
                'join_date' => $request->join_date,
                'date_of_birth' => $request->date_of_birth,
                'package_start_date' => $request->join_date,
                'package_end_date' => $request->package_end_date,
                'is_active' => true,
                'package_id' => $request->select_package,
                'phone_number' => $request->phone_number
            ]);

            MemberPayment::create([
                'branch_id' => $request->branch_id,
                'member_pk_id' => $member->id,
                'package_id' => $request->select_package,
                'amount_paid' => $request->amount_paid,
                'package_price' => $package->price,
                'payment_type' => $new_remaining_balance > 0 ? 'partial' : 'full',
                'due_amount' => $new_remaining_balance,
                'discount' => $request->discount??0,
                'payment_mode' => $request->payment_mode,
                'created_by' => $user->id,
                'payment_date' => date('Y-m-d'),
                'bill_date' => $request->join_date,
                'activation_date' => $request->join_date,
            ]);

            if ($new_remaining_balance > 0) {
                PendingPayments::create([
                    'branch_id' => $request->branch_id,
                    'member_pk_id' => $member->id,
                    'package_id' => $request->select_package,
                    'due_amount' => $new_remaining_balance
                ]);
            }

            $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.members.title')]));
        } catch (\Exception $e) {
            $request->session()->flash('Error', $e->getMessage());
        }
        return redirect(route('admin.members.index'));
    }

    public function edit(Members $member)
    {
        if (($redirect = $this->checkIsValidUser($member)) != null) {
            return redirect($redirect);
        }
        return view('admin.members.edit', ['member' => $member]);
    }

    public function update(MemberRequest $request, Members $member)
    {

        if (($redirect = $this->checkIsValidUser($member)) != null) {
            return redirect($redirect);
        }

        $data = $request->only('name', 'email', 'phone_number', 'gender', 'date_of_birth','address','height','weight');
        $member->fill($data)->save();

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.members.title')]));

        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('admin.members.index'));
    }

    public function checkIsValidUser($member)
    {
        $branch = auth()->user()->branch_id;
        if ($member->branch_id !== $branch) {
            $back = request()->get('back', route('admin.members.index'));
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => __('system.members.title')]));
            return $back;
        }
    }

    public function destroy(Members $member)
    {
        $request = request();
        if (($redirect = $this->checkIsValidUser($member)) != null) {
            return redirect($redirect);
        }

        PendingPayments::where('member_pk_id',$member->id)->delete();
        MembersAttendance::where('member_pk_id',$member->id)->delete();
        MemberPayment::where('member_pk_id',$member->id)->delete();

        $member->delete();
        $request->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.members.title')]));
        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('admin.members.index'));
    }

    public function attendance()
    {
        $request = request();
        $branch_id = auth()->user()->branch_id;
        $search = request()->member;
        $attendance_date = date('Y-m-d');

        $member = Members::where('branch_id', $branch_id)->where(function ($query) use ($search) {
            $query->where('email', $search)->orWhere('gym_customer_id', $search);
        })->first();

        if (isset($search) && $search != null) {
            if ($member == null) {
                $request->session()->flash('Error', trans('system.members.member_not_found'));
                return redirect(route('admin.attendance'));
            }

            $check = MembersAttendance::where('branch_id', $branch_id)->where('attendance_date', $attendance_date)->where('member_pk_id', $member->id)->count();
            if ($check==0) {
                MembersAttendance::create([
                    'branch_id' => $branch_id,
                    'check_in_time' => date('H:i:s'),
                    'attendance_date' => $attendance_date,
                    'member_pk_id' => $member->id,
                ]);
                $request->session()->flash('Success', trans('system.members.attendance_success'));
                return redirect(route('admin.attendance'));
            }
        }

//
//        $absentMembers = Members::whereNotIn('id', function ($query) use ($today) {
//            $query->select('member_pk_id')
//                ->from('members_attendances')
//                ->whereDate('attendance_date', $today);
//        })->where('branch_id', $branchId)->get();

        return view('admin.members.attendance', compact('member'));
    }

    public function attendance_save(Request $request, Members $member)
    {
        if (($redirect = $this->checkIsValidUser($member)) != null) {
            return redirect($redirect);
        }
        $attendance_date = date('Y-m-d');

        $branch_id = auth()->user()->branch_id;

        $check = MembersAttendance::where('branch_id', $branch_id)->where('attendance_date', $attendance_date)->where('member_pk_id', $member->id)->count();

        if ($check > 0) {
            $request->session()->flash('Error', trans('system.members.attendance_error'));
            return redirect(route('admin.attendance'));
        }

        MembersAttendance::create([
            'branch_id' => $branch_id,
            'check_in_time' => date('H:i:s'),
            'attendance_date' => $attendance_date,
            'member_pk_id' => $member->id,
        ]);

        $request->session()->flash('Success', trans('system.members.attendance_success'));
        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('admin.attendance'));
    }
}
