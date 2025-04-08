<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangelogRequest;
use App\Http\Requests\ProductFaqRequest;
use App\Models\Changelog;
use App\Models\ProductFaq;
use App\Models\User;
use App\Repositories\ChangelogRepository;
use App\Repositories\ProductFaqsRepository;
use Illuminate\Support\Facades\DB;

class ProductFaqsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show product_faqs')->only('index', 'show');
        $this->middleware('permission:add product_faqs')->only('create', 'store');
        $this->middleware('permission:edit product_faqs')->only('edit', 'update');
        $this->middleware('permission:delete product_faqs')->only('destroy');
    }

    public function index()
    {
        $request = request();
        $user = auth()->user();

        $params = $request->only('par_page', 'sort', 'direction', 'filter');
        $par_page = 15;
        if (in_array($request->par_page, [25, 50, 100])) {
            $par_page = $request->par_page;
        }
        $params['par_page'] = $par_page;

        $params['branch_id'] = $user->branch_id ?? 0;
        $product_faqs = (new ProductFaqsRepository())->getFaqs($params);
        return view('admin.product_faqs.index', ['product_faqs' => $product_faqs]);
    }

    public function create()
    {
        $user = auth()->user();

        if ($user->branch_id == null) {
            return redirect('products')->with(['Error' => __('system.dashboard.create_product')]);
        }
        $vendor_id = ($user->user_type == User::USER_TYPE_STAFF) ? $user->created_by : $user->id;
        $vendor = User::find($vendor_id);
        return view('admin.product_faqs.create', compact('vendor'));
    }

    public function store(ProductFaqRequest $request)
    {
        $user = auth()->user();
        DB::beginTransaction();
        $input = $request->only('branch_id', 'title','lang_title','lang_description','description');
        $input['created_by'] = $user->id;
        ProductFaq::create($input);
        $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.product_faqs.title')]));
        DB::commit();
        return redirect()->route('admin.product-faqs.index');
    }

    public function show(ProductFaq $product_faq)
    {
        if (($redirect = $this->checkValidItems($product_faq)) != null) {
            return redirect($redirect);
        }
        return view('admin.product_faqs.view', ['product_faq' => $product_faq]);
    }

    public function edit(ProductFaq $product_faq)
    {
        $user = auth()->user();
        $vendor_id = ($user->user_type == User::USER_TYPE_STAFF) ? $user->created_by : $user->id;

        if (($redirect = $this->checkValidItems($product_faq)) != null) {
            return redirect($redirect);
        }
        $vendor = User::find($vendor_id);

        return view('admin.product_faqs.edit', ['product_faq' => $product_faq, 'vendor' => $vendor]);
    }

    public function update(ProductFaqRequest $request, ProductFaq $product_faq)
    {
        $user = auth()->user();
        if (($redirect = $this->checkValidItems($product_faq)) != null) {
            return redirect($redirect);
        }
        $data = $request->only('branch_id', 'title','lang_title','lang_description','description');
        $data['created_by'] = $user->id;
        $product_faq->fill($data)->save();
        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.product_faqs.title')]));

        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('admin.product-faqs.index'));
    }

    public function checkValidItems($product_faq)
    {
        $user = auth()->user();
        $params['branch_id'] = $user->branch_id;
        $params['id'] = $product_faq->id;

        $product_faq = (new ProductFaqsRepository())->getBusinessItems($params);
        if (empty($product_faq)) {
            $back = request()->get('back', route('admin.product-faqs.index'));
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => __('system.product_faqs.title')]));
            return $back;
        }
    }


    public function destroy(ProductFaq $product_faq)
    {
        $request = request();
        if (($redirect = $this->checkValidItems($product_faq)) != null) {
            return redirect($redirect);
        }

        $product_faq->delete();
        $request->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.product_faqs.title')]));

        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('admin.product_faqs.index'));
    }
}
