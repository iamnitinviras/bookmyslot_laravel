<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class PackageRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'price' => ['required'],
            'number_of_months' => ['required'],
            'status' => ['required'],
            'description' => ['nullable'],
            'branch_id' => ['required', 'unique:packages,branch_id,null,id,name,' . $request->name],
        ];
        $request->request->add(['products' => array_filter($request->products ?? [])]);
        if (isset($this->package)) {
            $old_id = $this->package->id;
            $rules['branch_id'] = ['required', 'unique:packages,branch_id,' . $old_id . ',id,name,' . $request->name];
            if (count($langs) > 0) {
                $rules['lang_name.*'] = ['required'];
                $rules['lang_description.*'] = ['nullable'];
                $rules['branch_ids.*'] = ['required'];

                foreach ($langs as $key => $lang) {
                    $rules['lang_name.' . $key] = ['string', 'max:255', 'min:2'];
                    $rules['lang_description.' . $key] = ['nullable'];
                    $rules['branch_ids.' . $key] = ["unique:packages,branch_id,$old_id,id,lang_name->$key," .  str_replace("%", "%%", $request->lang_name[$key])];
                }
            }
        } elseif (count($langs) > 0) {
            $rules['lang_name.*'] = ['required'];
            $rules['lang_description.*'] = ['nullable'];
            foreach ($langs as $key => $lang) {
                $rules['lang_name.' . $key] = ['string', 'max:255', 'min:2'];
                $rules['lang_description.' . $key] = ['nullable'];
            }
        }
        return $rules;
    }

    public function messages()
    {

        $langs = getAllCurrentLanguages();
        $request = request();
        $lbl_category_image = strtolower(__('system.fields.category_image'));
        $lbl_name = strtolower(__('system.fields.name'));
        $category_icon = strtolower(__('system.packages.category_icon'));
        $messages = [
            "name.required" => __('validation.required', ['attribute' => $lbl_name]),
            "category_icon.required" => __('validation.required', ['attribute' => $category_icon]),
            "name.string" => __('validation.custom.invalid', ['attribute' => $lbl_name]),
            "name.max" => __('validation.custom.invalid', ['attribute' => $lbl_name]),

            "branch_id.required" => __('validation.custom.select_required', ['attribute' => 'board']),
            "branch_id.unique" => __('validation.unique', ['name' => $request->name, 'attribute' => $lbl_name]),
        ];
        if (count($langs) > 0) {

            foreach ($langs as $key => $lang) {
                $messages["lang_name.$key.string"] = __('validation.custom.invalid', ['attribute' => 'category name ' . strtolower($lang)]);
                $messages["lang_name.$key.max"] = __('validation.custom.invalid', ['attribute' => 'category name ' . strtolower($lang)]);
                $messages["lang_name.$key.min"] = __('validation.custom.invalid', ['attribute' => 'category name ' . strtolower($lang)]);
                $messages["branch_ids.$key.unique"]  = __('validation.unique', ['name' => $request->lang_name[$key], 'attribute' => $lbl_name . " " . strtolower($lang)]);
            }
        }
        return $messages;
    }
}
