<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plans;
use App\Models\FoodCategory;
use Illuminate\Http\Request;
use App\Models\Subscriptions;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Http\Requests\PlanRequest;
use App\Repositories\PlanRepository;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();
        $user = auth()->user();
        $params = $request->only('par_page', 'sort', 'direction', 'filter', 'plan_id');
        $params['plan_id'] = $params['plan_id'] ?? $user->plan_id;
        $plans = (new PlanRepository())->allPlan($params);
        $trial_days = config('custom.trial_days');
        $trial_branch = config('custom.trial_branch');
        $trial_staff = config('custom.trial_staff');
        $trial_member = config('custom.trial_member');
        return view('admin.plans.index', ['plans' => $plans, 'trial_days' => $trial_days, 'trial_branch' => $trial_branch, 'trial_staff' => $trial_staff, 'trial_member' => $trial_member]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.plans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlanRequest $request)
    {
        try {
            DB::beginTransaction();

            $request['type'] = $request->recurring_type;
            if ($request->is_staff_unlimited == 'yes') {
                unset($request['is_staff_unlimited']);
                $request['staff_unlimited'] = 'yes';
                $request['staff_limit'] = 0;
            } else {
                $request['staff_unlimited'] = 'no';
            }

            if ($request->is_unlimited_branch == 'yes') {
                unset($request['is_unlimited_branch']);
                $request['unlimited_branch'] = 'yes';
                $request['branch_limit'] = 0;
            } else {
                $request['unlimited_branch'] = 'no';
            }


            if ($request->is_unlimited_member == 'yes') {
                unset($request['is_unlimited_member']);
                $request['unlimited_member'] = 'yes';
                $request['member_limit'] = 0;
            } else {
                $request['unlimited_member'] = 'no';
            }

            Plans::create($request->all());
            DB::commit();
            $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.plans.title')]));
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            $request->session()->flash('Error', __('system.messages.operation_rejected'));
            return redirect()->back();
        }
        return redirect()->route('admin.plans.index');
    }


    public function edit($id)
    {
        $plan = Plans::where('plan_id', $id)->first();
        if (empty($plan)) {
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => 'Plan']));
            return redirect()->back();
        }

        return view('admin.plans.edit', ['plan' => $plan]);
    }

    public function update(PlanRequest $request, $id)
    {
        $plan = Plans::where('plan_id', $id)->first();
        if (empty($plan)) {
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => 'Plan']));
            return redirect()->back();
        }

        try {
            DB::beginTransaction();

            $request['type'] = $request->recurring_type;
            if ($request->is_staff_unlimited == 'yes') {
                unset($request['is_staff_unlimited']);
                $request['staff_unlimited'] = 'yes';
                $request['staff_limit'] = 0;
            } else {
                $request['staff_unlimited'] = 'no';
            }

            if ($request->is_unlimited_branch == 'yes') {
                unset($request['is_unlimited_branch']);
                $request['unlimited_branch'] = 'yes';
                $request['branch_limit'] = 0;
            } else {
                $request['unlimited_branch'] = 'no';
            }

            if ($request->is_unlimited_member == 'yes') {
                unset($request['is_unlimited_member']);
                $request['unlimited_member'] = 'yes';
                $request['member_limit'] = 0;
            } else {
                $request['unlimited_member'] = 'no';
            }

            $plan->update($request->all());

            DB::commit();
            $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.plans.title')]));
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            $request->session()->flash('Error', __('system.messages.operation_rejected'));
            return redirect()->back();
        }
        return redirect(route('admin.plans.index'));
    }


    public function destroy(Plans $plan)
    {
        $subscriptions = Subscriptions::where('plan_id', $plan->plan_id)->count();
        if ($subscriptions > 0) {
            request()->session()->flash('Error', __('system.fields.not_allowed_to_delete', ['name' => $plan->local_title]));
            return redirect()->back();
        }

        $plan->delete();
        request()->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.plans.title')]));
        return redirect(route('admin.plans.index'));
    }

    public function trailDetails(Request $request)
    {
        $request->validate([
            'trial_days' => ['required', 'integer'],
            'branch_limit' => ['required', 'integer'],
            'staff_limit' => ['required', 'integer'],
            'member_limit' => ['required', 'integer'],
        ]);

        $data = [
            'TRIAL_DAYS' => $request->trial_days,
            'TRIAL_BRANCH' => $request->branch_limit,
            'TRIAL_STAFF' => $request->staff_limit,
            'TRIAL_MEMBER' => $request->member_limit,
        ];
        DotenvEditor::setKeys($data)->save();
        Artisan::call('config:clear');
        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.environment.title')]));
        return redirect()->back();
    }
}
