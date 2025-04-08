<div class="row">
    <div class="col-md-12">
        @if($errors->any())
            {!! implode('', $errors->all('<div>:message</div>')) !!}
        @endif
        <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">
        <div class="card">
            <div class="card-header">
                {{trans('system.members.member_details')}}
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 ">
                        @php($lbl_name = __('system.fields.name'))
                        <div class="mb-3 form-group @error('name') has-danger @enderror">
                            <label class="form-label" for="name">{{ $lbl_name }} <span class="text-danger">*</span></label>
                            {!! html()->text('name')
                            ->class('form-control')
                            ->id('name')
                            ->autofocus()
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
                    <div class="col-md-3">
                        @php($lbl_email = __('system.fields.email'))
                        <div class="mb-3 form-group @error('email') has-danger @enderror">
                            <label class="form-label" for="email">{{ $lbl_email }}</label>
                            {!! html()->text('email', old('email'))
                            ->class('form-control')
                            ->id('email')
                            ->attribute('placeholder', $lbl_email)
                            ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower(__('system.fields.email'))]))
                            ->attribute('data-pristine-email-message', __('validation.custom.invalid', ['attribute' => strtolower(__('system.fields.email'))])) !!}
                            @error('email')
                            <div class="pristine-error text-help">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        @php($lbl_phone_number = __('system.fields.phone_number'))
                        <div class="mb-3 form-group @error('phone') has-danger @enderror">
                            <label class="form-label" for="pristine-phone-valid">{{ $lbl_phone_number }} <span class="text-danger">*</span></label>
                            {!! html()->text('phone', old('phone'))
                             ->class('form-control')
                             ->id('pristine-phone-valid')
                             ->attribute('placeholder', $lbl_phone_number)
                             ->required()
                             ->attribute('maxlength', 20)
                             ->attribute('onkeypress', 'return NumberValidate(event)')
                             ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_phone_number)])) !!}
                            @error('phone')
                            <div class="pristine-error text-help">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        @php($lbl_gender = __('system.fields.gender'))
                        <div class="mb-3 form-group @error('gender') has-danger @enderror">
                            <label class="form-label" for="gender">{{ $lbl_gender }} <span class="text-danger">*</span></label>
                            <select data-pristine-required-message="{{__('validation.required', ['attribute' => strtolower(trans('system.fields.gender'))])}}" name="gender" class="form-control" required>
                                <option value="">{{trans('system.fields.gender')}}</option>
                                <option {{ isset($member) && $member->gender == 'male' ? 'selected' : '' }} value="male">{{ trans('system.fields.male') }}</option>
                                <option {{ isset($member) && $member->gender == 'female' ? 'selected' : '' }} value="female">{{ trans('system.fields.female') }}</option>
                            </select>
                            @error('gender')
                            <div class="pristine-error text-help">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        @php($lbl_address = __('system.fields.address'))
                        <div class="mb-3 form-group @error('location') has-danger @enderror">
                            <label class="form-label" for="location">{{ $lbl_address }}</label>
                            {!! html()->textarea('location', old('location'))
                            ->class('form-control')
                            ->id('location')
                            ->attribute('placeholder', $lbl_address)
                            ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower(__('system.fields.address'))])) !!}
                            @error('location')
                            <div class="pristine-error text-help">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        @php($lbl_notes = __('system.fields.notes'))
                        <div class="mb-3 form-group @error('notes') has-danger @enderror">
                            <label class="form-label" for="notes">{{ $lbl_notes }}</label>
                            {!! html()->textarea('notes', old('notes'))
                            ->class('form-control')
                            ->id('notes')
                            ->attribute('placeholder', $lbl_notes)
                            ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower(__('system.fields.notes'))])) !!}
                            @error('notes')
                            <div class="pristine-error text-help">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        @php($lbl_next_follow_up_date = __('system.fields.next_follow_up_date'))
                        <div class="mb-3 form-group @error('next_follow_up_date') has-danger @enderror">
                            <label class="form-label" for="next_follow_up_date">{{ $lbl_next_follow_up_date }} <span class="text-danger">*</span></label>
                            {!! html()->date('next_follow_up_date', old('next_follow_up_date'))
                            ->class('form-control')
                            ->id('next_follow_up_date')
                            ->attribute('placeholder', $lbl_address)
                            ->required()
                            ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower(__('system.fields.address'))])) !!}
                            @error('next_follow_up_date')
                            <div class="pristine-error text-help">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
