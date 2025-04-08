<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberEnquiryRequest;
use App\Models\MemberEnquiry;
use App\Models\MemberTrial;
use App\Repositories\MemberRepository;
use Illuminate\Support\Facades\DB;

class MemberEnquiryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show members_enquiry')->only('index', 'show');
        $this->middleware('permission:add members_enquiry')->only('create', 'store');
        $this->middleware('permission:edit members_enquiry')->only('edit', 'update');
        $this->middleware('permission:delete members_enquiry')->only('destroy');
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

        $members = (new MemberRepository())->getAllMemberEnquiry($params);

        return view('admin.member_enquiry.index', ['members' => $members]);
    }

    public function create()
    {
        return view('admin.member_enquiry.create');
    }

    public function store(MemberEnquiryRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();
            MemberEnquiry::create([
                'branch_id'=>$request->branch_id,
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'gender'=>$request->gender,
                'next_follow_up_date'=>$request->next_follow_up_date,
                'location'=>$request->location,
                'interest'=>$request->interest,
                'notes'=>$request->notes,
                'created_by'=>$user->id,
            ]);

            DB::commit();
            $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.member_enquiry.title')]));
        } catch (\Exception $e) {
            DB::rollBack();
            $request->session()->flash('Error', $e->getMessage());
        }
        return redirect(route('admin.member-enquiry.index'));
    }

    public function edit(MemberEnquiry $member_enquiry)
    {
        if (($redirect = $this->checkIsValidUser($member_enquiry)) != null) {
            return redirect($redirect);
        }
        return view('admin.member_enquiry.edit', ['member' => $member_enquiry]);
    }

    public function update(MemberEnquiryRequest $request, MemberEnquiry $member_enquiry)
    {

        if (($redirect = $this->checkIsValidUser($member_enquiry)) != null) {
            return redirect($redirect);
        }

        $data = $request->only('name', 'branch_id', 'email', 'phone', 'gender','next_follow_up_date','location','interest','notes','enquiry_source');
        $member_enquiry->fill($data)->save();

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.member_enquiry.title')]));

        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('admin.member-enquiry.index'));
    }

    public function checkIsValidUser($member)
    {
        $branch=auth()->user()->branch_id;
        if ($member->branch_id !== $branch) {
            $back = request()->get('back', route('admin.members.index'));
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => __('system.member_enquiry.title')]));
            return $back;
        }
    }

    public function destroy(MemberEnquiry $member_enquiry)
    {
        $request = request();
        if (($redirect = $this->checkIsValidUser($member_enquiry)) != null) {
            return redirect($redirect);
        }
        $member_enquiry->delete();
        $request->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.member_enquiry.title')]));
        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('admin.member-enquiry.index'));
    }
}
