<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
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
        return [
            'title' => 'required|max:191',
            'amount' => 'required|numeric|gt:-1',
            'recurring_type' => 'required|in:day,onetime,monthly,weekly,yearly',
            'branch_limit' => 'required|numeric|gt:-1',
            'member_limit' => 'required|numeric|gt:-1',
            'staff_limit' => 'required|numeric|gt:-1',
            'user_id' => 'nullable'
        ];
    }
}
