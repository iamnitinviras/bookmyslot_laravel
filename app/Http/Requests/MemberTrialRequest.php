<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberTrialRequest extends FormRequest
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
        $rules = [
            'branch_id' => ['required'],
            'name' => ['required', 'string'],
            'phone_number' => ['required'],
            'duration_of_trial' => ['required']
        ];
        return $rules;
    }

    public function messages()
    {
        $lbl_phone_number = strtolower(__('system.fields.phone_number'));
        $lbl_first_name = strtolower(__('system.fields.name'));
        return [
            "name.required" => __('validation.required', ['attribute' => $lbl_first_name]),
            "name.string" => __('validation.custom.invalid', ['attribute' => $lbl_first_name]),
            "phone.required" => __('validation.required', ['attribute' => $lbl_phone_number]),
            "phone.regex" => __('validation.custom.invalid', ['attribute' => $lbl_phone_number]),
            "phone.unique" => __('validation.unique', ['attribute' => $lbl_phone_number]),
        ];
    }
}
