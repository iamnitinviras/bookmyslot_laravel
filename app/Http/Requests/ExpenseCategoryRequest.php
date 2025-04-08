<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExpenseCategoryRequest extends FormRequest
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
        $request=request();
        $id = isset($this->expense_category->id) ? $this->expense_category->id : 0;
        $rules = [
            'name' => ['required',
                Rule::unique('expense_categories')->where(function ($query) use ($request) {
                    return $query->where('branch_id', $request->branch_id);
                })
            ],
            'status' => ['required'],
        ];

        if (isset($this->expense_category)) {
            $rules['name'] = ['required',
                Rule::unique('expense_categories')->where(function ($query) use ($request) {
                    return $query->where('branch_id', $request->branch_id);
                })->ignore($id)
            ];
        }
        return $rules;
    }
    public function messages()
    {
        $lbl_name = strtolower(__('system.fields.name'));
        return [
            "name.required" => __('validation.required', ['attribute' => $lbl_name]),
            "name.unique" => __('validation.unique', ['attribute' => $lbl_name]),
        ];
    }
}
