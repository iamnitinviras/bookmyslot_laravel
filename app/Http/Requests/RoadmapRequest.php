<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class RoadmapRequest extends FormRequest
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
        $rules = [
            'title' => ['required', 'string', 'max:255', 'min:2'],
            'status' => ['required'],
            'is_default' => ['required'],
            'branch_id' => ['required', 'unique:roadmaps,branch_id,null,id,title,' . $request->title],
        ];

        $request->request->add(['board' => array_filter($request->board ?? [])]);
        if (isset($this->roadmap)) {
            $old_id = $this->roadmap->id;
            unset($rules['board.*']);
            unset($rules['board']);
            $rules['branch_id'] = ['required', 'unique:roadmaps,branch_id,' . $old_id . ',id,title,' . $request->title];
        }
        return $rules;
    }

    public function messages()
    {
        $request = request();
        $lbl_title = strtolower(__('system.roadmaps.title'));
        $messages = [
            "title.required" => __('validation.required', ['attribute' => $lbl_title]),
            "title.string" => __('validation.custom.invalid', ['attribute' => $lbl_title]),
            "title.max" => __('validation.custom.invalid', ['attribute' => $lbl_title]),
            "branch_id.required" => __('validation.custom.select_required', ['attribute' => 'board']),
            "branch_id.unique" => __('validation.unique', ['name' => $request->title, 'attribute' => $lbl_title]),
        ];
        return $messages;
    }
}
