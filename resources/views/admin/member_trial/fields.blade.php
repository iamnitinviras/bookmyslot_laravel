<div class="row">
    <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">
    <div class="col-md-4 ">
        @php($lbl_name = __('system.fields.name'))
        <div class="mb-3 form-group @error('name') has-danger @enderror">
            <label class="form-label" for="name">{{ $lbl_name }} <span class="text-danger">*</span></label>
            {!! html()->text('name')
            ->class('form-control')
            ->id('name')
            ->required()
            ->attribute('placeholder', $lbl_name)
            ->attribute('maxlength', 50)
            ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_name)]))
            ->attribute('data-pristine-minlength-message', __('validation.custom.invalid', ['attribute' => strtolower($lbl_name)])) !!}
            @error('name')
            <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        @php($lbl_phone_number = __('system.fields.phone_number'))
        <div class="mb-3 form-group @error('phone_number') has-danger @enderror">
            <label class="form-label" for="pristine-phone-valid">{{ $lbl_phone_number }} <span class="text-danger">*</span></label>
            {!! html()->text('phone_number', old('phone_number'))
             ->class('form-control')
             ->id('pristine-phone-valid')
             ->attribute('placeholder', $lbl_phone_number)
             ->required()
             ->attribute('maxlength', 20)
             ->attribute('onkeypress', 'return NumberValidate(event)')
             ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_phone_number)])) !!}
            @error('phone_number')
            <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        @php($lbl_number_of_days = __('system.fields.number_of_days'))
        <div class="mb-3 form-group">
            <label class="form-label" for="duration_of_trial">{{ $lbl_number_of_days }}</label>
            {!! html()->select('duration_of_trial', getNumberOfTrialDays())
            ->class('form-control form-select')
            ->id('duration_of_trial')
            ->required()
             !!}
        </div>
        @error('duration_of_trial')
        <div class="pristine-error text-help">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4 ">
        @php($lbl_notes = __('system.fields.notes'))
        <div class="mb-3 form-group @error('notes') has-danger @enderror">
            <label class="form-label" for="name">{{ $lbl_notes }}</label>
            {!! html()->textarea('notes')
            ->class('form-control')
            ->id('notes')
            ->attribute('placeholder', $lbl_notes) !!}
            @error('notes')
            <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
