<?php

namespace App\Http\Requests;

use App\Http\Controllers\Admin\BusinessController;
use Illuminate\Foundation\Http\FormRequest;

class GymRequest extends FormRequest
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
            'phone' => ['required'],
        ];
        return $rules;
    }
    public function messages()
    {
        $lbl_gym_name = strtolower(__('system.gym.name'));
        $lbl_phone = __('system.fields.phone_number');
        return [
            "title.required" => __('validation.required', ['attribute' => $lbl_gym_name]),
            "phone.required" => __('validation.required', ['attribute' => $lbl_phone]),
        ];
    }
}
