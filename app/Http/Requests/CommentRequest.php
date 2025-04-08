<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'message' => 'required',
            'user_name' => 'nullable'
        ];
        if (config('custom.enable_captcha_on_comments') == true) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }
        return $rules;
    }
}
