<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $request = request();
        $langs = getAllCurrentLanguages();
        $rules = [
            'question' => ['required'],
            'answer' => ['required'],
            'category_id' => ['required'],
        ];

        if (count($langs) > 0) {
            $rules['lang_question.*'] = ['nullable',];
            $rules['lang_answer.*'] = ['nullable',];

            foreach ($langs as $key => $lang) {
                $rules['lang_question.' . $key] = ['nullable','string'];
                $rules['lang_answer.' . $key] = ['nullable','string'];
            }
        }
        return $rules;
    }

    public function messages()
    {
        $langs = getAllCurrentLanguages();
        $request = request();
        $lbl_question = strtolower(__('system.faq.quetion'));
        $lbl_answer = strtolower(__('system.faq.answer'));
        $messages = [
            "question.required" => __('validation.required', ['attribute' => $lbl_question]),
            "answer.required" => __('validation.required', ['attribute' => $lbl_answer]),
        ];
        if (count($langs) > 0) {

            foreach ($langs as $key => $lang) {
                $messages["lang_question.$key.string"] = __('validation.custom.invalid', ['attribute' => 'question ' . strtolower($lang)]);
                $messages["lang_answer.$key.string"] = __('validation.custom.invalid', ['attribute' => 'answer ' . strtolower($lang)]);
            }
        }
        return $messages;
    }
}
