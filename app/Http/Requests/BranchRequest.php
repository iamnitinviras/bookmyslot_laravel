<?php

namespace App\Http\Requests;

use App\Http\Controllers\Admin\BusinessController;
use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
        $id = isset($this->branch->id) ? $this->branch->id : 0;
        $rules = [
            'branch_title' => ['required', 'string', 'max:255'],
            'branch_phone' => ['required'],
            'street_address' => ['required'],
            'city' => ['required'],
            'state' => ['required'],
            'country' => ['required'],
            'zip' => ['required'],
            'user_id' => ['required'],
        ];

        if (isset($this->product)) {
            $rules['branch_title'] = ['required', 'string', 'max:255', 'unique:branchs,branch_title,' . $this->product->id];
        }
        return $rules;
    }
    public function messages()
    {
        $lbl_board_name = strtolower(__('system.fields.board'));
        $lbl_address = __('system.fields.street_address');
        $lbl_city = __('system.fields.city');
        $lbl_state = __('system.fields.state');
        $lbl_country = __('system.fields.country');
        $lbl_zip = __('system.fields.zip');
        $lbl_phone = __('system.fields.phone_number');
        return [
            "branch_title.required" => __('validation.required', ['attribute' => $lbl_board_name]),
            "street_address.required" => __('validation.required', ['attribute' => $lbl_address]),
            "city.required" => __('validation.required', ['attribute' => $lbl_city]),
            "state.required" => __('validation.required', ['attribute' => $lbl_state]),
            "country.required" => __('validation.required', ['attribute' => $lbl_country]),
            "zip.required" => __('validation.required', ['attribute' => $lbl_zip]),
            "branch_phone.required" => __('validation.required', ['attribute' => $lbl_phone]),
            "branch_title.string" => __('validation.custom.invalid', ['attribute' => $lbl_board_name]),
            "branch_title.max" => __('validation.custom.invalid', ['attribute' => $lbl_board_name]),
            "branch_title.unique" => __('validation.unique', ['attribute' => $lbl_board_name]),
        ];
    }
}
