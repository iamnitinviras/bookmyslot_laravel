<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\PackageRequest;
use App\Models\Category;
use App\Models\Members;
use App\Models\Package;
use App\Repositories\CategoryRepository;
use App\Repositories\PackageRepository;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Illuminate\Http\UploadedFile;

class PackageController extends Controller
{
    public static function middleware(): array
    {
        return [
            'permission:show packages' => ['only' => ['index', 'show']],
            'permission:add packages' => ['only' => ['create', 'store']],
            'permission:edit packages' => ['only' => ['edit', 'update']],
            'permission:delete packages' => ['only' => ['destroy']],
        ];
    }

    public function index()
    {
        $request = request();
        $user = auth()->user();
        $params = $request->only('par_page', 'sort', 'direction', 'filter', 'branch_id');
        $params['branch_id'] = $user->branch_id ?? 0;
        $packages = (new PackageRepository())->getAllPackages($params);
        return view('admin.packages.index', ['packages' => $packages]);
    }

    public function create()
    {
        $user = auth()->user();
        if ($user->branch_id == null) {
            return redirect('branch')->with(['Error' => __('system.dashboard.create_product')]);
        }
        return view('admin.packages.create');
    }

    public function store(PackageRequest $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->only('name', 'description', 'branch_id', 'lang_description', 'lang_name', 'status', 'price', 'number_of_months');
            Package::create($input);
            DB::commit();
            $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.packages.title')]));
        } catch (\Exception $ex) {
            DB::rollback();
            $request->session()->flash('Error', $ex->getMessage());
            return redirect()->back();
        }
        return redirect()->route('admin.packages.index');
    }

    public function checkValidCategory($package_id, $user = null)
    {
        if (empty($user)) {
            $user = auth()->user();
        }

        $user->load([
            'branch.packages' => function ($q) use ($package_id)
            {
                $q->where('id', $package_id);
            }
        ]);

        if (!isset($user->branch) || count($user->branch->packages) == 0) {
            $back = request()->get('back', route('admin.packages.index'));
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => __('system.packages.title')]));
            return $back;
        }
    }

    public function edit(Package $package)
    {
        if (($redirect = $this->checkValidCategory($package->id)) != null) {
            return redirect($redirect);
        }
        return view('admin.packages.edit', ['package' => $package]);
    }

    public function update(PackageRequest $request, Package $package)
    {
        if (($redirect = $this->checkValidCategory($package->id)) != null) {
            return redirect($redirect);
        }
        $input = $request->only('name', 'lang_name', 'description', 'lang_description', 'status', 'price', 'number_of_months');
        $package->fill($input)->save();

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.packages.title')]));
        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('admin.packages.index'));
    }

    public function destroy(Package $package)
    {
        $request = request();
        if (($redirect = $this->checkValidCategory($package->id)) != null) {
            return redirect($redirect);
        }

        $memberCount = Members::where('package_id', $package->id)->count();

        if ($memberCount > 0) {
            request()->session()->flash('Error', __('system.packages.not_allowed_to_delete'));
            return redirect()->back();
        }

        $package->delete();
        $request->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.packages.title')]));
        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('admin.packages.index'));
    }

    public static function getCurrentProductAllCategories()
    {
        $user = request()->user();

        $user->load([
            'branch.packages' => function ($q)
            {
                $q->orderBy('name', 'asc');
            }
        ]);

        if ($user->product != null) {
            $packages = $user->product->packages->mapWithKeys(function ($package, $key)
            {
                return [$package->id => $package->name];
            });
            return $packages->toarray();
        }

        return ['' => __('system.fields.select_Category')];
    }
}
