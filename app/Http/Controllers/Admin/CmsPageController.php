<?php

namespace App\Http\Controllers\Admin;

use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\CmsPageRepository;

class CmsPageController extends Controller
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
        $params = $request->only('par_page', 'sort', 'direction', 'filter', 'id');
        $params['id'] = $params['id'] ?? $user->id;
        $cmsPages = (new CmsPageRepository())->allCmsPage($params);
        return view('admin.cms_page.index', ['cmsPages' => $cmsPages]);
    }


    public function create()
    {
        return redirect('cms-page');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            CmsPage::create($request->only('slug', 'title', 'description', 'lang_title', 'lang_description'));

            DB::commit();
            $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.cms.menu')]));
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            $request->session()->flash('Error', __('system.messages.operation_rejected'));
            return redirect()->back();
        }
        return redirect()->route('admin.cms-page.index');
    }


    public function show($id)
    {
        return redirect()->route('admin.cms-page.index');
    }


    public function edit($id)
    {
        $cmsPage = CmsPage::where('id', $id)->first();
        if (empty($cmsPage)) {
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => 'CmsPage']));
            return redirect()->back();
        }

        return view('admin.cms_page.edit', ['cmsPage' => $cmsPage]);
    }


    public function update(Request $request, $id)
    {
        $cmsPage = CmsPage::where('id', $id)->first();
        if (empty($cmsPage)) {
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => 'CmsPage']));
            return redirect()->back();
        }

        try {
            DB::beginTransaction();
            $cmsPage->update($request->only('slug', 'title', 'description', 'lang_title', 'lang_description'));

            DB::commit();
            $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.cms.menu')]));
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            $request->session()->flash('Error', __('system.messages.operation_rejected'));
            return redirect()->back();
        }
        return redirect(route('admin.cms-page.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect()->route('admin.cms-page.index');
    }
}
