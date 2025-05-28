<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blogs;
use App\Models\BlogCategory;
use App\Models\Comments;
use App\Repositories\BlogRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function index()
    {
        $request = request();
        $params = $request->only('par_page', 'sort', 'direction', 'filter');
        $blogs = (new BlogRepository())->getBlogs($params);
        return view('admin.blogs.posts.index', ['blogs' => $blogs]);
    }

    public function comments(Request $request)
    {
        $comments = Comments::orderBy('id', 'desc')->get();
        return view('admin.blogs.posts.comments', ['comments' => $comments]);
    }
    public function commentsApprove(Request $request, Comments $comment)
    {
        $comment->status = $request->approval_status;
        $comment->save();
        $request->session()->flash('Success', __('system.messages.comment_updated'));
        return redirect()->route('admin.posts.comments');
    }

    public function commentsDestroy(Request $request, Comments $comment)
    {
        $comment->delete();
        $request->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.fields.comment')]));
        return redirect()->route('admin.posts.comments');
    }
    public function create()
    {
        $categories = BlogCategory::where('status', 'active')->orderBy('category_name', 'asc')->get();
        return view('admin.blogs.posts.create', compact('categories'));
    }

    public function store(BlogRequest $request)
    {
        $user = auth()->user();
        try {
            DB::beginTransaction();
            $input = $request->only('title', 'description', 'slug', 'image', 'status', 'read_time', 'category_id', 'seo_keyword', 'seo_description', 'lang_title', 'lang_description');
            $input['created_by'] = $user->id;
            Blogs::create($input);
            DB::commit();
            $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.blogs.title')]));
        } catch (\Exception $ex) {
            DB::rollback();
            $request->session()->flash('Error', $ex->getMessage());
            return redirect()->back();
        }
        return redirect()->route('admin.posts.index');
    }

    public function edit(Blogs $post)
    {
        $categories = BlogCategory::where('status', 'active')->orderBy('category_name', 'asc')->get();
        return view('admin.blogs.posts.edit', ['blog' => $post, 'categories' => $categories]);
    }

    public function update(BlogRequest $request, Blogs $post)
    {
        $input = $request->only('title', 'description', 'image', 'status', 'slug', 'read_time', 'category_id', 'seo_keyword', 'seo_description', 'lang_title', 'lang_description');
        $post->fill($input)->save();

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.blogs.title')]));
        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('admin.posts.index'));
    }

    public function destroy(Blogs $post)
    {
        $request = request();
        $post->delete();
        $request->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.blogs.title')]));
        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('admin.posts.index'));
    }
}
