<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MemberRequest extends FormRequest
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
        $member=isset($this->member)?$this->member:null;

        $rules = [
            'name' => ['required', 'string', 'max:50'],
            'phone_number' => [
                'required',
                Rule::unique('members')->where(function ($query) use ($request) {
                    return $query->where('branch_id', $request->branch_id);
                })
                ->when($this->member, function ($rule) use ($member) {
                    return $rule->ignore($member->id);
                })
            ],
            'branch_id' => ['required'],
            'email' => [
                'nullable',
                'string',
                'email',
                'max:255',
                Rule::unique('members')->where(function ($query) use ($request) {
                    return $query->where('branch_id', $request->branch_id);
                })
                    ->when($this->member, function ($rule) use ($member) {
                        return $rule->ignore($member->id);
                    })
            ],
            'date_of_birth' => ['nullable'],
            'address' => ['nullable'],
            'height' => ['nullable'],
            'weight' => ['nullable'],
        ];

        if ($member==null){
            $rules['select_package'] =['required'];
            $rules['payment_mode']=['required'];
            $rules['payment_type']=['required'];
            $rules['join_date']=['required'];
            $rules['package_end_date']=['required'];
            $rules['amount_paid']=['required'];
            $rules['amount_pending']=['nullable'];
            $rules['discount']=['nullable'];
        }

        return $rules;
    }

    public function messages()
    {
        $lbl_phone_number = strtolower(__('system.fields.phone_number'));
        $lbl_name = strtolower(__('system.fields.name'));
        $lbl_email = strtolower(__('system.fields.email'));
        $lbl_join_date = strtolower(__('system.members.join_date'));
        $lbl_package_end_date = strtolower(__('system.members.package_end_date'));
        return [
            "join_date.required" => __('validation.required', ['attribute' => $lbl_join_date]),
            "package_end_date.required" => __('validation.required', ['attribute' => $lbl_package_end_date]),
            "name.required" => __('validation.required', ['attribute' => $lbl_name]),
            "name.string" => __('validation.custom.invalid', ['attribute' => $lbl_name]),

            "phone_number.required" => __('validation.required', ['attribute' => $lbl_phone_number]),
            "phone_number.regex" => __('validation.custom.invalid', ['attribute' => $lbl_phone_number]),
            "phone_number.unique" => __('validation.unique', ['attribute' => $lbl_phone_number]),

            "email.required" => __('validation.required', ['attribute' => $lbl_email]),
            "email.string" => __('validation.custom.invalid', ['attribute' => $lbl_email]),
            "email.email" => __('validation.custom.invalid', ['attribute' => $lbl_email]),
            "email.unique" => __('validation.unique', ['attribute' => $lbl_email]),
        ];
    }
}
