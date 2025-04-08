<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FaqQuestionRequest;
use App\Http\Requests\QuestionRequest;
use App\Models\FaqQuestion;
use App\Models\Questions;
use App\Repositories\FaqQuestionRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\RoadmapRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:show questions')->only('index', 'show');
        $this->middleware('permission:add questions')->only('create', 'store');
        $this->middleware('permission:edit questions')->only('edit', 'update');
        $this->middleware('permission:delete questions')->only('destroy');
    }

    public function index()
    {
        $request = request();
        $user = auth()->user();
        $params = $request->only('par_page', 'sort', 'direction', 'filter');
        $par_page = config('app.per_page');
        if (in_array($request->par_page, [10, 25, 50, 100])) {
            $par_page = $request->par_page;
        }
        $params['par_page'] = $par_page;
        $params['branch_id'] = $user->branch_id ?? 0;
        $questions = (new QuestionRepository())->getAll($params);
        return view('admin.questions.index', ['questions' => $questions]);
    }

    public function create()
    {
        return view('admin.questions.create');
    }

    public function store(QuestionRequest $request)
    {
        $user = auth()->user();
        try {
            DB::beginTransaction();
            $data=$request->only('category_id','question', 'answer', 'lang_question', 'lang_answer','status');
            $data['branch_id']=$user->branch_id ?? 0;
            $data['created_by']=$user->id;
            Questions::create($data);

            DB::commit();
            $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.questions.title')]));
        } catch (\Exception $ex) {
            DB::rollback();
            $request->session()->flash('Error', __('system.messages.operation_rejected'));
            return redirect()->back();
        }
        return redirect()->route('admin.questions.index');
    }

    public function edit(Questions $question)
    {
        return view('admin.questions.edit', ['question' => $question]);
    }

    public function update(QuestionRequest $request, Questions $question)
    {
        $user = auth()->user();
        try {
            DB::beginTransaction();
            $data=$request->only('question', 'answer', 'lang_question', 'lang_answer','status');
            $data['updated_by']=$user->id;
            $question->update($data);

            DB::commit();
            $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.questions.title')]));
        } catch (\Exception $ex) {
            DB::rollback();
            $request->session()->flash('Error', __('system.messages.operation_rejected'));
            return redirect()->back();
        }
        return redirect(route('admin.questions.index'));
    }

    public function destroy($id)
    {
        $faqQuestion = Questions::where('id', $id)->first();
        if (empty($faqQuestion)) {
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => __('system.questions.title')]));
            return redirect()->back();
        }
        $faqQuestion->delete();
        request()->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.questions.title')]));
        return redirect(route('admin.questions.index'));
    }
}
