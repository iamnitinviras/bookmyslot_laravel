<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TypeRequest extends FormRequest
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
            'branch_id' => ['required', 'unique:ticket_types,branch_id,null,id,title,' . $request->title],
        ];
        $request->request->add(['products' => array_filter($request->products ?? [])]);
        if (isset($this->ticket_type)) {
            $old_id = $this->ticket_type->id;
            unset($rules['products.*']);
            unset($rules['products']);
            $rules['branch_id'] = ['required', 'unique:ticket_types,branch_id,' . $old_id . ',id,title,' . $request->title];
            if (count($langs) > 0) {
                $rules['lang_title.*'] = ['required'];
                $rules['branch_ids.*'] = ['required'];

                foreach ($langs as $key => $lang) {
                    $rules['lang_title.' . $key] = ['string', 'max:255', 'min:2'];
                    $rules['branch_ids.' . $key] = ["unique:ticket_types,branch_id,$old_id,id,lang_title->$key," .  str_replace("%", "%%", $request->lang_title[$key])];
                }
            }
        } elseif (count($langs) > 0) {
            $rules['lang_title.*'] = ['required'];
            foreach ($langs as $key => $lang) {
                $rules['lang_title.' . $key] = ['string', 'max:255', 'min:2'];
            }
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
