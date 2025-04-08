<?php

namespace App\Http\Controllers\Admin;

use App\Models\FaqQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\FaqQuestionRequest;
use App\Repositories\FaqQuestionRepository;

class FaqQuestionController extends Controller
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
        $faqQuestions = (new FaqQuestionRepository())->allFaqQuestion($params);
        return view('admin.faq_questions.index', ['faqQuestions' => $faqQuestions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.faq_questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FaqQuestionRequest $request)
    {
        try {
            DB::beginTransaction();
            FaqQuestion::create($request->only('question', 'answer', 'lang_question', 'lang_answer'));

            DB::commit();
            $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.faq.title')]));
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            $request->session()->flash('Error', __('system.messages.operation_rejected'));
            return redirect()->back();
        }
        return redirect()->route('admin.faqs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $faqQuestion = FaqQuestion::where('id', $id)->first();
        if (empty($faqQuestion)) {
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => 'FaqQuestion']));
            return redirect()->back();
        }

        return view('admin.faq_questions.edit', ['faqQuestion' => $faqQuestion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $faqQuestion = FaqQuestion::where('id', $id)->first();
        if (empty($faqQuestion)) {
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => 'FaqQuestion']));
            return redirect()->back();
        }

        try {
            DB::beginTransaction();
            $faqQuestion->update($request->only('question', 'answer', 'lang_question', 'lang_answer'));

            DB::commit();
            $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.faq.title')]));
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            $request->session()->flash('Error', __('system.messages.operation_rejected'));
            return redirect()->back();
        }
        return redirect(route('admin.faqs.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faqQuestion = FaqQuestion::where('id', $id)->first();
        if (empty($faqQuestion)) {
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => 'FaqQuestion']));
            return redirect()->back();
        }
        $faqQuestion->delete();
        request()->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.faq.title')]));
        return redirect(route('admin.faqs.index'));
    }
}
