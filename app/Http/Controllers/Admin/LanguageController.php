<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LanguageDataSampleSheet;
use App\Models\User;
use App\Models\Language;
use App\Repositories\CategoryRepository;
use App\Repositories\ItemsRepository;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Spatie\Searchable\Search;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use File;
use Illuminate\Support\Facades\Lang;
use App\Repositories\FoodRepository;
use App\Http\Requests\LanguageRequest;
use App\Repositories\LanguageRepository;
use App\Repositories\FoodCategoryRepository;

class LanguageController extends Controller
{
    public function index()
    {
        $request = request();
        $params = $request->only('par_page', 'sort', 'direction', 'filter');
        $par_page = config('app.per_page');
        if (in_array($request->par_page, [10, 25, 50, 100])) {
            $par_page = $request->par_page;
        }
        $params['par_page'] = $par_page;
        $languages = (new LanguageRepository)->getAllLanguagesData($params);
        return view('admin.languages.index', ['languages' => $languages]);
    }

    public function create()
    {
        return view('admin.languages.create');
    }

    public function store(LanguageRequest $request)
    {
        $input = $request->only('name','direction');
        DB::beginTransaction();
        $input['store_location_name'] = generateLanguageStoreDirName($input['name']);

        $language = Language::create($input);
        $path = lang_path('en');
        \File::copyDirectory($path, lang_path($input['store_location_name']));

        $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.languages.title')]));

        DB::commit();
        return redirect(route('admin.languages.edit', ['language' => $language->id]));
    }

    public function edit(Language $language)
    {
        $request = request();
        $user = $request->user();
        $files = getAllLanguagesFiles();
        $file = current(array_flip($files));

        if (in_array($request->file, array_keys($files))) {
            $file = $request->file;
        }

        $english = getFileAllLanguagesData($file);
        if ($language->store_location_name == 'en') {
            $other = $english;
        } else {
            $other = getFileAllLanguagesData($file, $language->store_location_name);
        }
        return view('admin.languages.languages-data.edit', ['language' => $language, 'english' => $english, 'other' => $other, 'file' => $file]);
    }

    public function update(Request $request, Language $language)
    {

        $files = getAllLanguagesFiles();
        $user = $request->user();
        if (!in_array($request->file, array_keys($files))) {
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => __('system.languages.title')]));
        }

        $locations = $language->store_location_name;
        $filePath = lang_path($locations);
        File::isDirectory($filePath) or File::makeDirectory($filePath, 0777, true, true);
        File::put($filePath . "/" . $request->file . ".php", arrayToFileString($request->other));

        $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.languages_data.title')]));

        return redirect()->back();
    }

    public function defaultLanguage($language)
    {
        $request = request();

        $language = Language::where('store_location_name', $language)->first();
        if (!$language) {
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => __('system.languages.title')]));

            return redirect()->back();
        }

        $user = $request->user();
        session()->put('locale', $language->store_location_name);
        Cookie::queue('front_dir', $language->direction ?? 'ltr', 24 * 60 * 60 * 365);
        $request->session()->flash('Success', __('system.messages.change_success_message', ['model' => __('system.languages.title')]));

        return redirect()->back();
    }


    public function destroy(Language $language)
    {
        $request = request();
        if (strtolower($language->name) == 'english' || $language->store_location_name == config('app.app_locale')) {
            request()->session()->flash('Error', __('system.languages.can_not_remove'));
            return redirect()->back();
        }
        $path = lang_path($language->store_location_name);
        File::deleteDirectory($path);
        $language->delete();
        $request->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.languages.title')]));
        if ($request->back) {
            return redirect($request->back);
        }
        return redirect(route('admin.languages.index'));
    }

    public function sampleDownload(Request $request)
    {
        return (new LanguageDataSampleSheet())->download('invoices.xlsx');
    }

    public function sampleImport(Request $request)
    {
        $file = $request->validate([
            'import_file' => ['required', 'file', 'mimes:xlsx'],
        ]);

        dd($file);
    }
}
