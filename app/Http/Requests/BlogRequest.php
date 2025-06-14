<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
            'category_id' => ['required'],
            'title' => ['required', 'string', 'max:255', 'min:2'],
            'slug' => ['required','unique:blogs,slug'],
            'description' => ['required'],
        ];
        if (isset($this->post)){
            $rules['slug'] = ['required','unique:blogs,slug,' . $this->post->id];
        }
        return $rules;
    }
}
