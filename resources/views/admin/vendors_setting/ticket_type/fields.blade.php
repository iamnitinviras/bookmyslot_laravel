@csrf
<input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">
<div class="row p-3">
    <div class="col-lg-4 mb-2">
        <div class="form-group">
            <label class="text-label">{{ trans('system.fields.title') }}*</label>
            <input data-pristine-required-message="{{__('validation.required', ['attribute' => strtolower(trans('system.fields.title'))])}}" value="{{ old('title', $ticket_type->title??'')}}" type="text" name="title" class="form-control" placeholder="{{ trans('system.fields.title') }}" required>
        </div>
    </div>
    @foreach (getAllCurrentLanguages() as $key => $lang)
        <div class="col-lg-4 mb-2">
            @php($lbl_lang_title = __('system.fields.title') . ' ' . $lang)
            <div class="form-group @error('lang_title.' . $key) has-danger @enderror">
                <label class="form-label" for="name">{{ $lbl_lang_title }} <span class="text-danger">*</span></label>
                {!! Form::text("lang_title[$key]", null, [
                    'class' => 'form-control',
                    'id' => 'lang_title' . $key,
                    'autocomplete' => 'off',
                    'placeholder' => $lbl_lang_title,
                    'required' => 'true',
                    'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower($lbl_lang_title)]),
                    'data-pristine-minlength-message' => __('validation.custom.invalid', ['attribute' => strtolower($lbl_lang_title)]),
                ]) !!}
                @error('lang_title.' . $key)
                <div class="pristine-error text-help">{{ $message }}</div>
                @enderror
            </div>
        </div>
    @endforeach
</div>
