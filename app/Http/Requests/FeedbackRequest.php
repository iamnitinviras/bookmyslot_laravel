<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $request = request();
        $captcha_check=$request->captcha_check??false;
        $rules = [
            'title' => ['required', 'string', 'max:255', 'min:2'],
            'description' => ['nullable',],
            'branch_id' => ['required'],
            'roadmap_id' => ['nullable'],
            'feedback_image' => ['nullable'],
        ];
        if(config('app.enable_captcha_on_suggestion')==true && $captcha_check==true){
            $rules['g-recaptcha-response']='required|captcha';
        }
        return $rules;
    }

    public function messages()
    {
        $lbl_item_name = strtolower(__('system.fields.item_name'));
        $lbl_item_category = strtolower(__('system.fields.item_category'));
        $lbl_item_description = strtolower(__('system.fields.item_description'));

        $messages = [
            "name.required" => __('validation.required', ['attribute' => $lbl_item_name]),
            "name.string" => __('validation.custom.invalid', ['attribute' => $lbl_item_name]),
            "name.max" => __('validation.custom.invalid', ['attribute' => $lbl_item_name]),
            "description.string" => __('validation.custom.invalid', ['attribute' => $lbl_item_description]),
            "description.min" => __('validation.custom.invalid', ['attribute' => $lbl_item_description]),
            "categories.required" => __('validation.custom.select_required', ['attribute' => $lbl_item_category]),
        ];
        return $messages;
    }
}
