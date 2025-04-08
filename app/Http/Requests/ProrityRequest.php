<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProrityRequest extends FormRequest
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
        $langs = getAllCurrentLanguages();
        $rules = [
            'title' => ['required', 'string', 'max:255', 'min:2'],
            'branch_id' => ['required'],
        ];
        $request->request->add(['products' => array_filter($request->products ?? [])]);
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
        ];
        return $messages;
    }
}
