<div class="row">
    @if($errors->any())
        {!! implode('', $errors->all('<div>:message</div>')) !!}
    @endif
    <input type="hidden" name="user_id" id="user_id" value="{{ $vendors->id }}"/>
    <div class="col-md-4">
        @php($lbl_branch_name = __('system.fields.branch_name'))
        <div class="mb-3 form-group @error('branch_title') has-danger @enderror">
            <label class="form-label" for="name">{{ $lbl_branch_name }} <span class="text-danger">*</span></label>
            {!! html()->text('branch_title', old('branch_title'))
            ->class('form-control')
            ->id('branch_title')
            ->required()
            ->attribute('placeholder', $lbl_branch_name)
            ->attribute('maxlength', 255)
            ->attribute('minlength', 2)
            ->attribute('onkeypress', 'createSlug(this)')
            ->attribute('onblur', 'createSlug(this)')
            ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_branch_name)]))
            ->attribute('data-pristine-minlength-message', __('validation.custom.invalid', ['attribute' => strtolower($lbl_branch_name)])) !!}
            @error('branch_title')
            <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        @php($lbl_phone = __('system.fields.phone_number'))
        <div class="mb-3 form-group @error('branch_phone') has-danger @enderror">
            <label class="form-label" for="branch_phone">{{ $lbl_phone }} <span class="text-danger">*</span></label>
            {!! html()->text('branch_phone', old('branch_phone'))
            ->class('form-control')
            ->id('branch_phone')
            ->required()
            ->attribute('placeholder', $lbl_phone)
            ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_phone)])) !!}
            @error('branch_phone')
            <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
<div class="row mt-3">
    <h5 class="font-size-14 mb-3">{{ __('system.fields.address_details') }}</h5>
    <div class="col-md-4">
        @php($lbl_address = __('system.fields.street_address'))
        <div class="mb-3 form-group @error('street_address') has-danger @enderror">
            <label class="form-label" for="street_address">{{ $lbl_address }}</label>
            <input name="street_address" data-pristine-required-message="{{__('validation.required', ['attribute' => strtolower($lbl_address)])}}" required class="form-control" id="street_address" cols="30" placeholder="{{ $lbl_address }}" rows="2" value="{{ old('street_address', $branch->street_address??"") }}"/>
        </div>
        @error('street_address')
        <div class="pristine-error text-help">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-2">
        @php($lbl_city = __('system.fields.city'))

        <div class="mb-3 form-group @error('city') has-danger @enderror">
            <label class="form-label" for="input-city">{{ $lbl_city }}</label>
            <input type="text"  data-pristine-required-message="{{__('validation.required', ['attribute' => strtolower($lbl_city)])}}" required name="city" class="form-control" id="input-city" placeholder="{{ $lbl_city }}" value="{{ old('city', $branch->city??"") }}">

        </div>
        @error('city')
        <div class="pristine-error text-help">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-2">
        @php($lbl_state = __('system.fields.state'))

        <div class="mb-3 form-group @error('state') has-danger @enderror">
            <label class="form-label" for="input-state">{{ $lbl_state }}</label>
            <input type="text"  data-pristine-required-message="{{__('validation.required', ['attribute' => strtolower($lbl_state)])}}" required name="state" class="form-control" id="input-state" placeholder="{{ $lbl_state }}" value="{{ old('state', $branch->state??"") }}">

        </div>
        @error('state')
        <div class="pristine-error text-help">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-2">
        @php($lbl_country = __('system.fields.country'))

        <div class="mb-3 form-group @error('country') has-danger @enderror">
            <label class="form-label" for="input-country">{{ $lbl_country }}</label>
            <input type="text"  data-pristine-required-message="{{__('validation.required', ['attribute' => strtolower($lbl_country)])}}" required name="country" class="form-control" id="input-country" placeholder="{{ $lbl_country }}" value="{{ old('country', $branch->country??"") }}">

        </div>
        @error('country')
        <div class="pristine-error text-help">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-2">
        @php($lbl_zip = __('system.fields.zip'))
        <div class="mb-3 form-group @error('zip') has-danger @enderror">
            <label class="form-label" for="input-zip">{{ $lbl_zip }}</label>
            <input type="text"  data-pristine-required-message="{{__('validation.required', ['attribute' => strtolower($lbl_address)])}}" required name="zip" class="form-control pristine-custom-pattern" id="input-zip" placeholder="{{ $lbl_zip }}" maxlength="8" value="{{ old('zip', $branch->zip??"") }}"
                   maxlength="8" data-pristine-pattern-message="{{ __('validation.custom.invalid', ['attribute' => strtolower($lbl_zip)]) }}">

        </div>
        @error('zip')
        <div class="pristine-error text-help">{{ $message }}</div>
        @enderror
    </div>

</div>
@push('page_scripts')
    <script>
        var validEle = document.getElementById("pristine-valid");
        var validEle = new Pristine(validEle);
    </script>
@endpush
