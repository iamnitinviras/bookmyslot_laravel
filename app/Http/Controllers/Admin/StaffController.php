<?php

namespace App\Http\Controllers\Admin;

use App\Models\Branch;
use App\Models\BranchUser;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StaffRequest;
use App\Repositories\StaffRepository;

class StaffController extends Controller
{
    public static function middleware(): array
    {
        return [
            'permission:show staff' => ['only' => ['index', 'show']],
            'permission:add staff' => ['only' => ['create', 'store']],
            'permission:edit staff' => ['only' => ['edit', 'update']],
            'permission:delete staff' => ['only' => ['destroy']],
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

        $owner_id = $user->id;
        if ($user->user_type == User::USER_TYPE_STAFF) {
            $owner_id = $user->created_by;
        }

        $params['par_page'] = $par_page;
        $params['created_by'] = $owner_id;
        $params['user_id'] = $user->id;

        $users = (new StaffRepository())->getStaff($params);

        return view('admin.staff.index', ['users' => $users]);
    }

    public function create()
    {
        $user = auth()->user();
        $owner_id = $user->id;
        if ($user->user_type == User::USER_TYPE_STAFF) {
            $owner_id = $user->created_by;
        }

        if (!$this->checkPlan($user)) {
            return redirect()->route('admin.staffs.index')->with(['Error' => __('system.plans.staff_extends')]);
        }

        $branches = Branch::select('id', 'title')->where('user_id', $owner_id)->orderBY('title', 'asc')->get();
        $staffBoard = array();

        return view('admin.staff.create', compact('branches', 'staffBoard'));
    }

    public function store(StaffRequest $request)
    {
        DB::beginTransaction();
        try {

            $user = auth()->user();
            if (!$this->checkPlan($user)) {
                return redirect()->route('admin.staffs.index')->with(['Error' => __('system.plans.staff_extends')]);
            }
            $data = $request->all();

            $owner_id = $user->id;
            if ($user->user_type == User::USER_TYPE_STAFF) {
                $owner_id = $user->created_by;
            }

            $newUser = User::create(['first_name' => $data['first_name'], 'last_name' => $data['last_name'], 'email' => $data['email'], 'phone_number' => $data['phone_number'], 'profile_image' => $data['profile_image'] ?? null, 'password' => Hash::make($data['password']), 'status' => User::STATUS_ACTIVE, 'created_by' => $owner_id, 'branch_id' => $user->branch_id, 'user_type' => User::USER_TYPE_STAFF, 'email_verified_at' => date('Y-m-d H:i:s'),]);

            if (isset($request->branches) && count($request->branches) > 0) {
                foreach ($request->branches as $key => $branch_id) {
                    BranchUser::create(['branch_id' => $branch_id, 'user_id' => $newUser->id, 'role' => BranchUser::ROLE_STAFF,]);

                    //Set Default Restro
                    if ($key == 0) {
                        $newUser->branch_id = $branch_id;
                        $newUser->save();
                    }
                }
            }


            //Save permission
            $newUser->assignRole('staff');

            if (isset($data['permission']) && count($data['permission']) > 0) {
                $newUser->givePermissionTo($data['permission']);
            }

            DB::commit();
            $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.staffs.title')]));
        } catch (Exception $e) {
            DB::rollBack();
            $request->session()->flash('Error', $e->getMessage());
        }
        return redirect(route('admin.staffs.index'));
    }

    public function show(User $staff)
    {
        if (($redirect = $this->checkIsValidUser($staff)) != null) {
            return redirect($redirect);
        }
        $staff = $staff;
        return view('admin.staff.show', compact('staff'));
    }

    public function edit(User $staff)
    {

        $user = auth()->user();

        if (($redirect = $this->checkIsValidUser($staff)) != null) {
            return redirect($redirect);
        }

        $owner_id = $user->id;
        $assigned_product = array();

        if ($user->user_type == User::USER_TYPE_STAFF) {
            $owner_id = $user->created_by;
            $assigned_product = BranchUser::where('user_id', $user->id)->pluck('branch_id')->toArray();
        }

        $staffBoard = BranchUser::where('user_id', $staff->id)->pluck('branch_id')->toArray();

        $branches = Branch::select('id', 'title')->where('user_id', $owner_id)->when(isset($assigned_product), function ($query) use ($assigned_product)
        {
            if (count($assigned_product) > 0) {
                $query->whereIn('id', $assigned_product);
            }
        })->orderBY('title', 'asc')->get();

        return view('admin.staff.edit', ['user' => $staff, 'staffBoard' => $staffBoard, 'branches' => $branches]);
    }

    public function update(StaffRequest $request, User $staff)
    {

        if (($redirect = $this->checkIsValidUser($staff)) != null) {
            return redirect($redirect);
        }

        $data = $request->only('first_name', 'email', 'last_name', 'phone_number', 'permission', 'profile_image');
        $staff->fill($data)->save();

        BranchUser::where('user_id', $staff->id)->delete();

        if (isset($request->branches) && count($request->branches) > 0) {
            foreach ($request->branches as $key => $branch_id) {
                BranchUser::create(['branch_id' => $branch_id, 'user_id' => $staff->id, 'role' => BranchUser::ROLE_STAFF,]);

                //Set Default Restro
                if ($key == 0) {
                    $staff->branch_id = $branch_id;
                    $staff->save();
                }
            }
        }


        //Update Permission
        if (isset($data['permission']) && count($data['permission']) > 0) {
            $staff->syncPermissions($data['permission']);
        }

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.staffs.title')]));

        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('admin.staffs.index'));
    }

    public function checkIsValidUser($staff)
    {
        $login_user = auth()->user();

        if ($login_user->user_type == User::USER_TYPE_ADMIN) {
            return route('admin.staff.index');
        }

        $owner_id = $login_user->id;
        if ($staff->user_type == User::USER_TYPE_STAFF) {
            $owner_id = $staff->created_by;
        }

        if ($staff->created_by != $owner_id) {
            $back = request()->get('back', route('admin.staffs.index'));
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => __('system.staffs.title')]));
            return $back;
        }
    }

    public function destroy(User $staff)
    {
        $request = request();

        if (($redirect = $this->checkIsValidUser($staff)) != null) {
            return redirect($redirect);
        }

        BranchUser::where('user_id', $staff->id)->delete();

        $staff->delete();

        $request->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.staffs.title')]));

        if ($request->back) {
            return redirect($request->back);
        }

        return redirect(route('admin.staffs.index'));
    }

    protected function checkPlan($user)
    {

        $userPlan = $user->subscriptionData();
        if ($user->user_type == User::USER_TYPE_STAFF) {
            $owner = User::find($user->created_by);
            $userPlan = $owner->subscriptionData();
        }

        $vendor_id = ($user->user_type == User::USER_TYPE_STAFF) ? $user->created_by : $user->id;
        $staffCount = User::where('created_by', $vendor_id)->where('user_type', User::USER_TYPE_STAFF)->count();

        if ($user->user_type != User::USER_TYPE_ADMIN && $userPlan && $user->free_forever != true) {
            if ((!$userPlan || $staffCount >= $userPlan->staff_limit) && $userPlan->staff_unlimited != 'yes') {
                return false;
            }
        } else if ($user->user_type != User::USER_TYPE_ADMIN && !$userPlan) {
            return false;
        }
        return true;
    }

    public function updatePassword(Request $request, User $staff)
    {
        try {

            $this->validate($request, ['new_password' => ['required', 'string', 'min:8'], 'confirm_password' => ['required', 'same:new_password']]);

            $staff->password = Hash::make($request->new_password);
            $staff->save();

            $request->session()->flash('Success', __('system.messages.change_success_message', ['model' => __('system.fields.password')]));
            return back()->with('success', 'Password change successfully');
        } catch (\ErrorException $e) {
            $request->session()->flash('Success', $e->getMessage());
            return back();
        }
    }
}
