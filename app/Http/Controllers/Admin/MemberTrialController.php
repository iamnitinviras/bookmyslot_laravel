<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberTrialRequest;
use App\Models\Branch;
use App\Models\BranchUser;
use App\Models\MemberTrial;
use App\Models\User;
use App\Repositories\MemberRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MemberTrialController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show members_trial')->only('index', 'show');
        $this->middleware('permission:add members_trial')->only('create', 'store');
        $this->middleware('permission:edit members_trial')->only('edit', 'update');
        $this->middleware('permission:delete members_trial')->only('destroy');
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

        $member_trials = (new MemberRepository())->getAllTrialMember($params);

        return view('admin.member_trial.index', ['member_trials' => $member_trials]);
    }

    public function create()
    {
        return view('admin.member_trial.create');
    }

    public function store(MemberTrialRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();
            MemberTrial::create([
                'branch_id'=>$request->branch_id,
                'name'=>$request->name,
                'phone_number'=>$request->phone_number,
                'trainer'=>$request->trainer,
                'notes'=>$request->notes,
                'created_by'=>$user->id,
                'duration_of_trial'=>$request->duration_of_trial,
            ]);

            DB::commit();
            $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.members.trial')]));
        } catch (\Exception $e) {
            DB::rollBack();
            $request->session()->flash('Error', $e->getMessage());
        }
        return redirect(route('admin.member-trial.index'));
    }

    public function edit(MemberTrial $member_trial)
    {
        if (($redirect = $this->checkIsValidUser($member_trial)) != null) {
            return redirect($redirect);
        }
        return view('admin.member_trial.edit', ['member_trial' => $member_trial]);
    }

    public function update(MemberTrialRequest $request, MemberTrial $member_trial)
    {

        if (($redirect = $this->checkIsValidUser($member_trial)) != null) {
            return redirect($redirect);
        }

        $data = $request->only('name', 'branch_id', 'phone_number', 'duration_of_trial', 'notes');
        $member_trial->fill($data)->save();

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.members.trial')]));

        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('admin.member-trial.index'));
    }

    public function checkIsValidUser($member)
    {
        $branch=auth()->user()->branch_id;
        if ($member->branch_id !== $branch) {
            $back = request()->get('back', route('admin.member-trial.index'));
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => __('system.members.trial')]));
            return $back;
        }
    }

    public function destroy(MemberTrial $member_trial)
    {
        $request = request();
        if (($redirect = $this->checkIsValidUser($member_trial)) != null) {
            return redirect($redirect);
        }
        $member_trial->delete();
        $request->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.members.trial')]));
        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('admin.member-trial.index'));
    }
}
