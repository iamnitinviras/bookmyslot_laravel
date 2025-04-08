<div class="row">
    <div class="col-md-4">
        @php($lbl_name = __('system.fields.name'))
        <div
            class="mb-3 form-group @error('name') has-danger @enderror  @error('branch_id') has-danger @enderror">
            <label class="form-label" for="name">{{ $lbl_name }} <span class="text-danger">*</span></label>
            {!! html()->text('name', old('name'))
                ->class('form-control')
                ->id('name')
                ->autocomplete('off')
                ->autofocus()
                ->required()
                ->attribute('placeholder', $lbl_name)
                ->attribute('maxlength', 150)
                ->attribute('minlength', 2)
                ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_name)]))
                ->attribute('data-pristine-minlength-message', __('validation.custom.invalid', ['attribute' => strtolower($lbl_name)])) !!}
            @error('name')
                <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
            @error('branch_id')
                 <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        @php($lbl_description = __('system.fields.description'))
        <div class="mb-3 form-group">
            <label class="form-label" for="input-address">{{ $lbl_description }}</label>
            {!! html()->textarea('description', old('description'))
            ->class('form-control')
            ->id('description')
            ->attribute('placeholder', $lbl_description)
            ->attribute('rows', 2) !!}
        </div>
        @error('description')
        <div class="pristine-error text-help">{{ $message }}</div>
        @enderror
    </div>
</div>

@foreach (getAllCurrentLanguages() as $key => $lang)
    <div class="card">
        <div class="card-header">
            <b>{{$lang}}</b>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    @php($lbl_name = __('system.fields.name') . ' ' . $lang)
                    <div
                        class="mb-3 form-group @error('lang_name.' . $key) has-danger @enderror @error('restaurant_ids.' . $key) has-danger @enderror">
                        <label class="form-label" for="name">
                            {{ $lbl_name }}
                            <span class="text-danger">*</span>
                        </label>
                        {!! html()->text("lang_name[$key]")
                            ->class('form-control')
                            ->id('name')
                            ->autocomplete('off')
                            ->attribute('placeholder', $lbl_name)
                            ->required()
                            ->attribute('maxlength', 150)
                            ->attribute('minlength', 2)
                            ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_name)]))
                            ->attribute('data-pristine-minlength-message', __('validation.custom.invalid', ['attribute' => strtolower($lbl_name)])) !!}

                        @error('lang_name.' . $key)
                        <div class="pristine-error text-help">{{ $message }}</div>
                        @enderror
                        @error('restaurant_ids.' . $key)
                        <div class="pristine-error text-help">{{ $message }}</div>
                        @enderror

                    </div>
                </div>
                <div class="col-md-4">
                    @php($lbl_description = __('system.fields.description') . ' ' . $lang)
                    <div
                        class="mb-3 form-group @error('lang_description.' . $key) has-danger @enderror @error('restaurant_ids.' . $key) has-danger @enderror">
                        <label class="form-label" for="name">
                            {{ $lbl_description }}
                        </label>
                        {!! html()->textarea("lang_description[$key]", old("lang_description[$key]"))
                            ->class('form-control')
                            ->id('name')
                            ->attribute('autocomplete', 'off')
                            ->attribute('placeholder', $lbl_description)
                            ->rows(2) !!}

                        @error('lang_description.' . $key)
                        <div class="pristine-error text-help">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
<div class="row">
    <div class="w-100"></div>
    <div class="col-md-4">
        @php($status=$category->status??'active')
        <div class="mb-3 form-group @error('status') has-danger @enderror  @error('status') has-danger @enderror">
            <label class="form-label w-100" for="name">{{trans('system.fields.status')}}</label>
            <div class="form-check form-check-inline">
                <input @if($status=='active') checked @endif class="form-check-input" type="radio" name="status" id="active" value="active">
                <label class="form-check-label" for="active">{{trans('system.crud.active')}}</label>
            </div>
            <div class="form-check form-check-inline">
                <input @if($status=='inactive') checked @endif class="form-check-input" type="radio" name="status" id="inactive" value="inactive">
                <label class="form-check-label" for="inactive">{{trans('system.crud.inactive')}}</label>
            </div>
        </div>
    </div>
    <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">
    @if (isset($edit))
        <input type="hidden" name="action" value="edit">
    @endif
</div>
