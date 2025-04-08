<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
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
            'title' => ['required'],
        ];
        return $rules;
    }
    public function messages()
    {
        $lbl_name = strtolower(__('system.fields.title'));
        return [
            "title.required" => __('validation.required', ['attribute' => $lbl_name]),
        ];
    }
}
