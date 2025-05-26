<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BranchRequest;
use App\Http\Requests\ProductRequest;
use App\Models\Branch;
use App\Models\BranchUser;
use App\Models\ProductUser;
use App\Models\Package;
use App\Models\User;
use App\Repositories\BranchRepository;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BranchController extends Controller
{
    public static function middleware(): array
    {
        return [
            'permission:show branch' => ['only' => ['index', 'show']],
            'permission:add branch' => ['only' => ['create', 'store']],
            'permission:edit branch' => ['only' => ['edit', 'update']],
            'permission:delete branch' => ['only' => ['destroy']],
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
        if ($user->user_type == User::USER_TYPE_STAFF) {
            $assigned_branch = BranchUser::where('user_id', $user->id)->pluck('branch_id')->toArray();
            $params['assigned_branch'] = $assigned_branch;
            $params['user_id'] = $user->created_by;
        } elseif ($user->user_type == User::USER_TYPE_VENDOR) {
            $params['user_id'] = $user->id;
        }

        $branchs = (new BranchRepository())->getBranches($params);
        return view('admin.branch.index', ["branchs" => $branchs]);
    }

    protected function checkPlan($user)
    {

        $userPlan = $user->subscriptionData();
        if ($user->user_type == User::USER_TYPE_STAFF) {
            $owner = User::find($user->created_by);
            $userPlan = $owner->subscriptionData();
        }

        $vendor_id = ($user->user_type == User::USER_TYPE_STAFF) ? $user->created_by : $user->id;
        $gymBranch = Branch::where('user_id', $vendor_id)->count();

        if ($user->user_type != User::USER_TYPE_ADMIN && $userPlan && $user->free_forever != true) {

            if ((!$userPlan || $gymBranch >= $userPlan->branch_limit) && $userPlan->unlimited_branch != 'yes') {
                return false;
            }
        } else if ($user->user_type != User::USER_TYPE_ADMIN && !$userPlan) {
            return false;
        }
        return true;
    }

    public function create()
    {
        $user = auth()->user();
        if ($this->checkPlan($user) == false) {
            if ($user->user_type == User::USER_TYPE_STAFF) {
                return redirect()->route('home')->with(['Error' => __('system.plans.branch_extends')]);
            }
            return redirect()->route('admin.vendor.plan')->with(['Error' => __('system.plans.branch_extends')]);
        }

        if ($user->user_type == User::USER_TYPE_ADMIN) {
            $vendors = User::where('user_type', User::USER_TYPE_VENDOR)->where('status', 1)->orderBy('first_name', 'asc')->get();
        } else {
            $vendor_id = ($user->user_type == User::USER_TYPE_STAFF) ? $user->created_by : $user->id;
            $vendors = User::find($vendor_id);
        }

        return view('admin.branch.create', compact('vendors'));
    }

    public function store(BranchRequest $request)
    {

        $user = auth()->user();
        if ($this->checkPlan($user) == false) {
            if ($user->user_type == User::USER_TYPE_STAFF) {
                return redirect()->route('home')->with(['Error' => __('system.plans.branch_extends')]);
            }
            return redirect()->route('admin.vendor.plan')->with(['Error' => __('system.plans.branch_extends')]);
        }

        $user = auth()->user();
        $data = $request->only('branch_title', 'user_id', 'branch_phone', 'street_address', 'city', 'state', 'country', 'zip');


        DB::beginTransaction();
        $branch = Branch::create($data);

        if ($user->user_type == User::USER_TYPE_STAFF) {
            BranchUser::create(['branch_id' => $branch->id, 'user_id' => $user->id, 'role' => User::USER_TYPE_STAFF,]);
        }

        //Assign Vendor To Business
        BranchUser::create([
            'branch_id' => $branch->id,
            'user_id' => $branch->user_id,
            'role' => User::USER_TYPE_VENDOR
        ]);

        if ($user->branch_id == null) {
            $user->branch_id = $branch->id;
            $user->save();
        }

        DB::commit();
        $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.branch.title')]));
        return redirect(route('admin.branch.index'));
    }

    public function show(Branch $branch)
    {
        if (($redirect = $this->checkIsValidBoard($branch)) != null) {
            return redirect($redirect);
        }
        $branch->load([
            'created_user',
            'users' => function ($q)
            {
                $q->limit(5);
            }
        ]);
        return view('admin.branch.view', ['board' => $branch]);
    }

    public function edit(Branch $branch)
    {
        $user = auth()->user();
        if (($redirect = $this->checkIsValidBoard($branch)) != null) {
            return redirect($redirect);
        }

        if ($user->user_type == User::USER_TYPE_ADMIN) {
            $vendors = User::where('user_type', User::USER_TYPE_VENDOR)->where('status', 1)->orderBy('first_name', 'asc')->get();
        } else {
            $vendor_id = ($user->user_type == User::USER_TYPE_STAFF) ? $user->created_by : $user->id;
            $vendors = User::find($vendor_id);
        }
        return view('admin.branch.edit', ['branch' => $branch, 'vendors' => $vendors]);
    }

    public function checkIsValidBoard($branch)
    {
        $user = auth()->user();
        if ($user->user_type == User::USER_TYPE_ADMIN) {
            return;
        }
        $branch->load([
            'users' => function ($q) use ($user)
            {
                $q->where('user_id', $user->id);
            }
        ]);

        if (count($branch->users) == 0) {
            $back = request()->get('back', route('admin.branch.index'));
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => __('system.branch.title')]));
            return $back;
        }
    }

    public function update(BranchRequest $request, Branch $branch)
    {
        if (($redirect = $this->checkIsValidBoard($branch)) != null) {
            return redirect($redirect);
        }

        $data = $request->only('branch_title', 'user_id', 'branch_phone', 'street_address', 'city', 'state', 'country', 'zip');
        $branch->fill($data)->save();

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.branch.title')]));

        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('admin.branch.index'));
    }

    public function defaultBranch(Branch $branch)
    {
        if (($redirect = $this->checkIsValidBoard($branch)) != null) {
            return redirect($redirect);
        }
        $user = request()->user();
        $request = request();
        $user->branch_id = $branch->id;
        $user->save();
        $request->session()->flash('Success', __('system.messages.change_success_message', ['model' => __('system.branch.title')]));

        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('home'));
    }

    public function destroy(Branch $branch)
    {
        $user = auth()->user();
        $request = request();
        if (($redirect = $this->checkIsValidBoard($branch)) != null) {
            return redirect($redirect);
        }

        $branch->load([
            'users' => function ($q) use ($branch)
            {
                $q->where('users.branch_id', $branch->id);
            }
        ]);

        DB::beginTransaction();

        if (count($branch->users) > 0) {
            foreach ($branch->users as $restoUser) {
                $restoUser->load([
                    'branch' => function ($q) use ($branch)
                    {
                        $q->wherePivot('branch_id', '!=', $branch->id);
                    }
                ]);
                if (count($restoUser->branchs) > 0) {
                    $restoUser->branch_id = $restoUser->branchs->first()->id;
                } else {
                    $restoUser->branch_id = null;
                }
                $restoUser->save();
            }
        }
        BranchUser::where('branch_id', $branch->id)->delete();

        $latestBoard = Branch::where('user_id', $branch->user_id)->latest()->first();
        if ($branch->id == $user->branch_id) {
            if (!empty($latestBoard)) {
                $user->branch_id = $latestBoard->id;
            } else {
                $user->branch_id = null;
            }
        }
        $user->save();

        //Update Related Users
        if ($branch->id == $user->branch_id) {
            $branchUsers = BranchUser::where('branch_id', $branch->id)->get();
            if (count($branchUsers) > 0) {
                $newBoardId = isset($latestBoard->id) ? $latestBoard->id : null;
                BranchUser::where('branch_id', $branch->id)->update([
                    'branch_id' => $newBoardId
                ]);
            }
        }

        $branch->delete();

        DB::commit();
        $request->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.branch.title')]));

        if ($request->back) {
            return redirect($request->back);
        }

        return redirect(route('admin.branch.index'));
    }

    public static function getVendors()
    {
        return (new BranchRepository())->getVendorsList();
    }

    public function genarteQR(Branch $branch)
    {
        $request = request();

        $size = $request->size && ($request->size >= 100 && $request->size <= 325) ? $request->size : 325;
        $logo_size = $request->logo_size && ($request->logo_size >= 0.25 && $request->logo_size <= 0.5) ? $request->logo_size : 0.25;
        if (isset($request->image) && $request->has('image')) {
            $file = $request->image;
            $logo = File::get($file->getRealPath());
        } elseif ($request->logo == true && isset($branch->qr_details['logo'])) {
            $logo = Storage::get($branch->qr_details['logo']);
        }

        $color = $request->color ?? "#000000";
        list($cr, $cg, $cb) = sscanf($color, "#%02x%02x%02x");
        $color_transparent = $request->color_transparent && ($request->color_transparent >= 1 && $request->color_transparent <= 100) ? $request->color_transparent : 100;

        $back_color = $request->back_color ?? "#ffffff";
        list($br, $bg, $bb) = sscanf($back_color, "#%02x%02x%02x");
        $back_color_transparent = $request->back_color_transparent && ($request->back_color_transparent >= 0 && $request->back_color_transparent <= 100) ? $request->back_color_transparent : 1;

        $gradient_method = $request->gradient_method && in_array($request->gradient_method, ['vertical', 'horizontal', 'diagonal', 'inverse_diagonal', 'radial']) ? $request->gradient_method : 'vertical';
        $gradient_color1 = $request->gradient_color1 ?? "#000000";
        list($l1r, $l1g, $l1b) = sscanf($gradient_color1, "#%02x%02x%02x");
        $gradient_color2 = $request->gradient_color2 ?? "#000000";
        list($l2r, $l2g, $l2b) = sscanf($gradient_color2, "#%02x%02x%02x");

        $qr_style = $request->qr_style && in_array($request->qr_style, ['square', 'dot', 'round']) ? $request->qr_style : 'square';
        $qr_style_size = $request->qr_style_size && ($request->qr_style_size >= 0.25 && $request->qr_style_size <= 0.5) ? $request->qr_style_size : 1;

        $eye_style = $request->eye_style && in_array($request->eye_style, ['square', 'circle']) ? $request->eye_style : 'square';
        $eye_inner_color = $request->eye_inner_color ?? "#000000";
        list($eir, $eig, $eib) = sscanf($eye_inner_color, "#%02x%02x%02x");
        $eye_outer_color = $request->eye_outer_color ?? "#000000";
        list($eor, $eog, $eob) = sscanf($eye_outer_color, "#%02x%02x%02x");

        $QR = QrCode::size($size)->format('png');
        if (isset($logo)) {
            if ($request->save == 0) {
                list($width, $height) = getimagesize(imageDataToCollection($logo));
                if (($width * $logo_size) > 500 || ($height * $logo_size) > 500) {
                    $logo_size /= 2;
                }
            }
            $QR = $QR->mergeString($logo, $logo_size);
        }
        $QR = $QR->backgroundColor($br ?? 0, $bg ?? 0, $bb ?? 0, $back_color_transparent);

        if ($request->gradient_method) {
            $QR = $QR->gradient($l1r ?? 0, $l1g ?? 0, $l1b ?? 0, $l2r ?? 0, $l2g ?? 0, $l2b ?? 0, $gradient_method);
        } else if ($request->color) {
            $QR = $QR->color($cr ?? 0, $cg ?? 0, $cb ?? 0, $color_transparent);
        }

        $QR = $QR->eye($eye_style);
        $QR = $QR->eyeColor(0, $eir ?? 0, $eig ?? 0, $eib ?? 0, $eor ?? 0, $eog ?? 0, $eob ?? 0);
        $QR = $QR->eyeColor(1, $eir ?? 0, $eig ?? 0, $eib ?? 0, $eor ?? 0, $eog ?? 0, $eob ?? 0);
        $QR = $QR->eyeColor(2, $eir ?? 0, $eig ?? 0, $eib ?? 0, $eor ?? 0, $eog ?? 0, $eob ?? 0);
        $QR = $QR->style($qr_style);

        if ($request->save == 1) {
            $qr_details = [
                'size' => $size,
                'logo' => $request->logo == true && isset($branch->qr_details['logo']) ? $branch->qr_details['logo'] : '',

                'is_logo_visible' => $request->is_logo_visible,
                'logo_size' => $logo_size,

                'color' => sprintf("#%02x%02x%02x", $cr ?? 0, $cg ?? 0, $cb ?? 0),
                'color_transparent' => $color_transparent,

                'back_color' => sprintf("#%02x%02x%02x", $br ?? 0, $bg ?? 0, $bb ?? 0),
                'back_color_transparent' => $back_color_transparent,

                'gradient_method' => $request->gradient_method != null ? $gradient_method : '',
                'gradient_color1' => sprintf("#%02x%02x%02x", $l1r ?? 0, $l1g ?? 0, $l1b ?? 0),
                'gradient_color2' => sprintf("#%02x%02x%02x", $l2r ?? 0, $l2g ?? 0, $l2b ?? 0),

                'qr_style' => $qr_style,
                'qr_style_size' => $qr_style_size,

                'eye_style' => $eye_style,
                'eye_inner_color' => sprintf("#%02x%02x%02x", $eir ?? 0, $eig ?? 0, $eib ?? 0),
                'eye_outer_color' => sprintf("#%02x%02x%02x", $eor ?? 0, $eog ?? 0, $eob ?? 0),
            ];
            if ($request->has('image')) {
                $file = $request->image;
                $qr_details['logo'] = uploadFile($file, 'qr_code_logo');
            }
            $branch->fill(['qr_details' => $qr_details])->save();
            $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.qr_code.menu')]));
        }

        $image = base64_encode($QR->generate(route('frontend.branch', ['branch' => $branch->slug])), );
        return view('admin.branch.genarteqr', ['image' => $image]);
    }
}
