<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class BlogCategoryRequest extends FormRequest
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
            'category_image' => ['nullable', 'max:50000', "image", 'mimes:jpeg,png,jpg,gif,svg'],
            'slug' => ['required', 'unique:blog_categories,slug'],
            'category_name' => ['required', 'unique:blog_categories,category_name'],
            'status' => ['required'],
        ];

        if (isset($this->blog_category)) {
            $rules['category_name'] = ['required', 'unique:blog_categories,category_name,' . $this->blog_category->id];
            $rules['slug'] = ['required', 'unique:blog_categories,slug,' . $this->blog_category->id];
        }
        return $rules;
    }

    public function messages()
    {
        $lbl_category_image = strtolower(__('system.fields.category_image'));
        $lbl_category_name = strtolower(__('system.fields.category_name'));
        $messages = [
            "category_name.unique" => __('validation.unique', ['attribute' => $lbl_category_name]),
            "category_image.max" => __('validation.gt.file', ['attribute' => $lbl_category_image, 'value' => 50000]),
            "category_image.image" => __('validation.enum', ['attribute' => $lbl_category_image]),
            "category_image.mimes" => __('validation.enum', ['attribute' => $lbl_category_image]),
            "category_name.required" => __('validation.required', ['attribute' => $lbl_category_name]),
            "category_name.string" => __('validation.custom.invalid', ['attribute' => $lbl_category_name]),
            "category_name.max" => __('validation.custom.invalid', ['attribute' => $lbl_category_name]),
        ];
        return $messages;
    }
}
