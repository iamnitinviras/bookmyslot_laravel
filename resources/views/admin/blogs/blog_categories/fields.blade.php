<div class="row">
    <div class="col-md-4">
        @php($lbl_category_name = __('system.fields.category_name'))
        <div
            class="mb-3 form-group @error('category_name') has-danger @enderror">
            <label class="form-label" for="category_name">{{ $lbl_category_name }} <span class="text-danger">*</span></label>
            {!! html()->text('category_name')
            ->class('form-control')
            ->id('category_name')
            ->attribute('autocomplete', 'off')
            ->attribute('placeholder', $lbl_category_name)
            ->attribute('onkeypress','createSlug(this)')
            ->attribute('onblur','createSlug(this)')
            ->required()
            ->maxlength(150)
            ->minlength(2)
            ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_category_name)]))
            ->attribute('data-pristine-minlength-message', __('validation.custom.invalid', ['attribute' => strtolower($lbl_category_name)])) !!}
            @error('category_name')
            <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3 form-group  @error('slug') has-danger @enderror">
            @php($lbl_category_slug = __('system.fields.slug'))
            <label for="input-slug">{{ $lbl_category_slug }} <span class="text-danger">*</span></label>
            {!! html()->text('slug')
            ->class('form-control')
            ->id('input-slug')
            ->attribute('autocomplete', 'off')
            ->attribute('placeholder', $lbl_category_slug)
            ->attribute('onkeypress','createSlug(this)')
            ->attribute('onblur','createSlug(this)')
            ->required()
            ->minlength(3)
            ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_category_slug)]))
            ->attribute('data-pristine-minlength-message', __('validation.custom.invalid', ['attribute' => strtolower($lbl_category_slug)])) !!}
            @error('slug')
            <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        @php($lbl_description = __('system.fields.description'))
        <div class="mb-3 form-group">
            <label class="form-label" for="input-address">{{ $lbl_description }}</label>
            {!! html()->textarea('description')
             ->class('form-control')
             ->id('description')
             ->attribute('placeholder', $lbl_description)
             ->rows(2) !!}

        </div>
        @error('description')
        <div class="pristine-error text-help">{{ $message }}</div>
        @enderror
    </div>

</div>

@foreach (getAllCurrentLanguages() as $key => $lang)
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <b>{{$lang}}</b>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @php($lbl_category_name = __('system.fields.category_name') . ' ' . $lang)
                            <div
                                class="mb-3 form-group @error('lang_category_name.' . $key) has-danger @enderror ">
                                <label class="form-label" for="category_name">{{ $lbl_category_name }}</label>
                                {!! html()->text("lang_category_name[$key]")
                                ->class('form-control')
                                ->id('lang_category_name'.$key)
                                ->attribute('autocomplete', 'off')
                                ->attribute('placeholder', $lbl_category_name)
                                ->maxlength(150)
                                ->minlength(2)
                                ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_category_name)]))
                                ->attribute('data-pristine-minlength-message', __('validation.custom.invalid', ['attribute' => strtolower($lbl_category_name)])) !!}
                                @error('lang_category_name.' . $key)
                                <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            @php($lbl_description = __('system.fields.description') . ' ' . $lang)

                            <div class="mb-3 form-group @error('lang_description.' . $key) has-danger @enderror">
                                <label class="form-label" for="input-address">{{ $lbl_description }}</label>
                                {!! html()->textarea("lang_description[$key]")
                                 ->class('form-control')
                                 ->id('description')
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
        </div>
    </div>
@endforeach
<div class="row">
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
    @if (isset($edit))
        <input type="hidden" name="action" value="edit">
    @endif
</div>
