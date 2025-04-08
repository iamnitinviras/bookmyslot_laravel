<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseCategoryRequest;
use App\Http\Requests\PackageRequest;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Package;
use App\Repositories\ExpenseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show expenses_categories')->only('index','show');
        $this->middleware('permission:add expenses_categories')->only('create','store');
        $this->middleware('permission:edit expenses_categories')->only('edit','update');
        $this->middleware('permission:delete expenses_categories')->only('destroy');
    }

    public function index()
    {
        $request = request();
        $user = auth()->user();
        $params = $request->only('par_page', 'sort', 'direction', 'filter', 'branch_id');
        $params['branch_id'] = $user->branch_id??0;
        $expenses_categories = (new ExpenseRepository())->getAllExpensCategories($params);
        return view('admin.expenses_categories.index', ['expenses_categories' => $expenses_categories]);
    }

    public function create()
    {
        $user = auth()->user();
        if($user->branch_id==null){
            return redirect('branch')->with(['Error' => __('system.dashboard.create_branch')]);
        }
        return view('admin.expenses_categories.create');
    }

    public function store(ExpenseCategoryRequest $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->only('name', 'description', 'branch_id','lang_description', 'lang_name','status');
            ExpenseCategory::create($input);
            DB::commit();
            $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.expenses_categories.title')]));
        } catch (\Exception $ex) {
            DB::rollback();
            $request->session()->flash('Error',$ex->getMessage());
            return redirect()->back();
        }
        return redirect()->route('admin.expense-categories.index');
    }

    public function checkValidCategory($package_id, $user = null)
    {
        if (empty($user)) {
            $user = auth()->user();
        }

        $user->load(['branch.expenses_categories' => function ($q) use ($package_id) {
            $q->where('id', $package_id);
        }]);

        if (!isset($user->branch) || count($user->branch->expenses_categories) == 0) {
            $back = request()->get('back', route('admin.expense-categories.index'));
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => __('system.expenses_categories.title')]));
            return $back;
        }
    }

    public function edit(ExpenseCategory $expense_category)
    {
        if (($redirect = $this->checkValidCategory($expense_category->id)) != null) {
            return redirect($redirect);
        }
        return view('admin.expenses_categories.edit', ['expense_category' => $expense_category]);
    }

    public function update(ExpenseCategoryRequest $request, ExpenseCategory $expense_category)
    {
        if (($redirect = $this->checkValidCategory($expense_category->id)) != null) {
            return redirect($redirect);
        }
        $input = $request->only('name', 'description','lang_description', 'lang_name','status');
        $expense_category->fill($input)->save();

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.expenses_categories.title')]));
        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('admin.expense-categories.index'));
    }

    public function destroy(ExpenseCategory $expense_category)
    {
        $request = request();
        if (($redirect = $this->checkValidCategory($expense_category->id)) != null) {
            return redirect($redirect);
        }

        $expense_category->delete();
        $request->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.expenses_categories.title')]));
        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('admin.expense-categories.index'));
    }
}
