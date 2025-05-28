<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlogCategoryRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BlogCategoryController extends Controller
{

    public function index()
    {
        $request = request();
        $user = auth()->user();
        $params = $request->only('par_page', 'sort', 'direction', 'filter');
        $categories = (new BlogCategoryRepository())->getCategories($params);
        return view('admin.blog_categories.index', ['categories' => $categories]);
    }

    public function create()
    {
        $user = auth()->user();
        return view('admin.blog_categories.create');
    }

    public function store(BlogCategoryRequest $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->only('category_name', 'slug', 'description', 'category_image', 'lang_category_name', 'lang_description', 'status');
            $input['sort_order'] = BlogCategory::max('sort_order') + 1;
            BlogCategory::create($input);
            DB::commit();
            $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.categories.title')]));
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollback();
            $request->session()->flash('Error', __('system.messages.operation_rejected'));
            return redirect()->back();
        }
        return redirect()->route('admin.blog-categories.index');
    }

    public function edit(BlogCategory $blog_category)
    {
        return view('admin.blog_categories.edit', ['category' => $blog_category]);
    }

    public function update(BlogCategoryRequest $request, BlogCategory $blog_category)
    {
        $input = $request->only('category_name', 'slug', 'category_image', 'description', 'lang_category_name', 'lang_description', 'status');
        $blog_category->fill($input)->save();

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.blog_categories.title')]));
        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('admin.blog-categories.index'));
    }

    public function destroy(BlogCategory $blog_category)
    {
        $request = request();
        $blog_category->delete();
        $request->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.blog_categories.title')]));
        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('admin.blog-categories.index'));
    }

    public function positionChange()
    {
        $request = request();
        BlogCategory::where('id', $request->id)->update(['sort_order' => $request->index]);
        return true;
    }
}
