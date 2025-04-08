<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseRequest;
use App\Http\Requests\PackageRequest;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Members;
use App\Models\Package;
use App\Repositories\ExpenseRepository;
use App\Repositories\PackageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show expenses')->only('index','show');
        $this->middleware('permission:add expenses')->only('create','store');
        $this->middleware('permission:edit expenses')->only('edit','update');
        $this->middleware('permission:delete expenses')->only('destroy');
    }

    public function index()
    {
        $request = request();
        $user = auth()->user();
        $params = $request->only('par_page', 'sort', 'direction', 'filter', 'branch_id');
        $params['branch_id'] = $user->branch_id??0;
        $expenses = (new ExpenseRepository())->getAllExpenses($params);
        return view('admin.expenses.index', ['expenses' => $expenses]);
    }

    public function create()
    {
        $user = auth()->user();
        if($user->branch_id==null){
            return redirect('branch')->with(['Error' => __('system.dashboard.create_branch')]);
        }
        $categories=ExpenseCategory::where('status','active')->orderBy('name','asc')->get();
        return view('admin.expenses.create',compact('categories'));
    }

    public function store(ExpenseRequest $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->only('title', 'description', 'branch_id','category_id','amount','expense_date','payment_method','created_by','receipt_path');
            Expense::create($input);
            DB::commit();
            $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.expenses.title')]));
        } catch (\Exception $ex) {
            DB::rollback();
            $request->session()->flash('Error',$ex->getMessage());
            return redirect()->back();
        }
        return redirect()->route('admin.expenses.index');
    }

    public function checkValidCategory($expense_id, $user = null)
    {
        if (empty($user)) {
            $user = auth()->user();
        }

        $user->load(['branch.expenses' => function ($q) use ($expense_id) {
            $q->where('id', $expense_id);
        }]);

        if (!isset($user->branch) || count($user->branch->expenses) == 0) {
            $back = request()->get('back', route('admin.expenses.index'));
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => __('system.expenses.title')]));
            return $back;
        }
    }

    public function edit(Expense $expense)
    {
        if (($redirect = $this->checkValidCategory($expense->id)) != null) {
            return redirect($redirect);
        }
        $categories=ExpenseCategory::where('status','active')->orderBy('name','asc')->get();
        return view('admin.expenses.edit', ['expense' => $expense,'categories'=>$categories]);
    }

    public function update(ExpenseRequest $request, Expense $expense)
    {
        if (($redirect = $this->checkValidCategory($expense->id)) != null) {
            return redirect($redirect);
        }
        $input = $request->only('title', 'description', 'branch_id','category_id','amount','expense_date','payment_method','created_by','receipt_path');
        $expense->fill($input)->save();

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.expenses.title')]));
        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('admin.expenses.index'));
    }

    public function destroy(Expense $expense)
    {
        $request = request();
        if (($redirect = $this->checkValidCategory($expense->id)) != null) {
            return redirect($redirect);
        }

        $expense->delete();
        $request->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.expenses.title')]));
        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('admin.expenses.index'));
    }
}
