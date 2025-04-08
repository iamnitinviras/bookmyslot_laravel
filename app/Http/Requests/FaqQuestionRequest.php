<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqQuestionRequest extends FormRequest
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
        ];

        if (count($langs) > 0) {
            $rules['lang_question.*'] = ['required',];
            $rules['lang_answer.*'] = ['required',];

            foreach ($langs as $key => $lang) {
                $rules['lang_question.' . $key] = ['string'];
                $rules['lang_answer.' . $key] = ['string'];
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
