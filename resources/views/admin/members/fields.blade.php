<div class="row">
    <div class="col-md-12">
        <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">
        <div class="card">
            <div class="card-header">
                {{trans('system.members.member_details')}}
            </div>
            @if($errors->any())
                {!! implode('', $errors->all('<div>:message</div>')) !!}
            @endif
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
                            ->attribute('data-pristine-email-message', __('validation.custom.invalid', ['attribute' => strtolower(__('system.fields.email'))])) !!}
                            @error('email')
                            <div class="pristine-error text-help">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
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
                    <div class="col-md-3">
                        @php($lbl_gender = __('system.fields.gender'))
                        <div class="mb-3 form-group @error('gender') has-danger @enderror">
                            <label class="form-label" for="gender">{{ $lbl_gender }} <span class="text-danger">*</span></label>
                            <select data-pristine-required-message="{{__('validation.required', ['attribute' => strtolower(trans('system.fields.gender'))])}}" name="gender" class="form-control" required>
                                <option value="">{{trans('system.fields.gender')}}</option>
                                <option {{ old('gender',isset($member) && $member->gender) == 'male' ? 'selected' : '' }} value="male">{{ trans('system.fields.male') }}</option>
                                <option {{ old('gender',isset($member) && $member->gender)  == 'female' ? 'selected' : '' }} value="female">{{ trans('system.fields.female') }}</option>
                            </select>
                            @error('gender')
                            <div class="pristine-error text-help">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        @php($lbl_date_of_birth = __('system.fields.date_of_birth'))
                        <div class="mb-3 form-group @error('date_of_birth') has-danger @enderror">
                            <label class="form-label" for="date_of_birth">{{ $lbl_date_of_birth }}</label>
                            {!! html()->date('date_of_birth', old('date_of_birth'))
                            ->class('form-control')
                            ->id('date_of_birth')
                            ->attribute('placeholder', $lbl_date_of_birth)
                            ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower(__('system.fields.date_of_birth'))]))
                            ->attribute('data-pristine-email-message', __('validation.custom.invalid', ['attribute' => strtolower(__('system.fields.date_of_birth'))])) !!}
                            @error('date_of_birth')
                            <div class="pristine-error text-help">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        @php($lbl_address = __('system.fields.address'))
                        <div class="mb-3 form-group @error('address') has-danger @enderror">
                            <label class="form-label" for="address">{{ $lbl_address }}</label>
                            {!! html()->textarea('address', old('address'))
                            ->class('form-control')
                            ->id('address')
                            ->attribute('placeholder', $lbl_address)
                            ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower(__('system.fields.address'))]))
                            ->attribute('data-pristine-email-message', __('validation.custom.invalid', ['attribute' => strtolower(__('system.fields.address'))])) !!}
                            @error('address')
                            <div class="pristine-error text-help">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        @php($lbl_height = __('system.fields.height'))
                        <div class="mb-3 form-group @error('height') has-danger @enderror">
                            <label class="form-label" for="height">{{ $lbl_height }}</label>
                            {!! html()->text('height', old('height'))
                            ->class('form-control')
                            ->id('height')
                            ->attribute('placeholder', $lbl_height)
                            ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower(__('system.fields.date_of_birth'))]))
                            ->attribute('data-pristine-email-message', __('validation.custom.invalid', ['attribute' => strtolower(__('system.fields.date_of_birth'))])) !!}
                            @error('height')
                            <div class="pristine-error text-help">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        @php($lbl_weight = __('system.fields.weight'))
                        <div class="mb-3 form-group @error('weight') has-danger @enderror">
                            <label class="form-label" for="weight">{{ $lbl_weight }}</label>
                            {!! html()->text('weight', old('weight'))
                            ->class('form-control')
                            ->id('weight')
                            ->attribute('placeholder', $lbl_weight)
                            ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower(__('system.fields.weight'))]))
                            ->attribute('data-pristine-email-message', __('validation.custom.invalid', ['attribute' => strtolower(__('system.fields.weight'))])) !!}
                            @error('weight')
                            <div class="pristine-error text-help">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                </div>
            </div>
        </div>

        @if(!isset($member))
            <div class="card">
                <div class="card-header">
                    {{trans('system.members.member_package')}}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            @php($lbl_select_package = __('system.packages.select_package'))
                            <div class="mb-3 form-group">
                                <label class="form-label" for="select_package">{{ $lbl_select_package }} <span class="text-danger">*</span></label>
                                {!! html()->select('select_package', $packages)
                                ->class('form-control form-select')
                                ->id('select_package')
                                ->attribute('onchange','get_package_details(this)')
                                ->attribute('data-url',route('admin.single.package'))
                                ->required()!!}
                            </div>
                            @error('select_package')
                            <div class="pristine-error text-help">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            @php($lbl_package_price = __('system.packages.package_price'))
                            <div class="mb-3 form-group @error('package_price') has-danger @enderror">
                                <label class="form-label" for="package_price">{{ $lbl_package_price }}</label>
                                {!! html()->text('package_price', old('package_price')??0 )
                                ->class('form-control')
                                ->id('package_price')
                                ->isReadonly()
                                ->attribute('placeholder', $lbl_package_price) !!}
                                @error('package_price')
                                <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            @php($lbl_join_date = __('system.members.join_date'))
                            <div class="mb-3 form-group @error('join_date') has-danger @enderror">
                                <label class="form-label" for="join_date">{{ $lbl_join_date }}</label>
                                {!! html()->date('join_date', old('join_date',date('Y-m-d')))
                                ->class('form-control')
                                ->id('join_date')
                                ->required()
                                ->attribute('placeholder', $lbl_join_date)!!}
                                @error('join_date')
                                <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            @php($lbl_package_end_date = __('system.members.package_end_date'))
                            <div class="mb-3 form-group @error('package_end_date') has-danger @enderror">
                                <label class="form-label" for="package_end_date">{{ $lbl_package_end_date }}</label>
                                {!! html()->date('package_end_date', old('package_end_date'))
                                ->class('form-control')
                                ->required()
                                ->id('package_end_date')
                                ->attribute('placeholder', $lbl_package_end_date)!!}
                                @error('package_end_date')
                                <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    {{trans('system.members.member_payment')}}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            @php($lbl_payment_mode = __('system.members.payment_mode'))
                            <div class="mb-3 form-group">
                                <label class="form-label" for="payment_mode">{{ $lbl_payment_mode }} <span class="text-danger">*</span></label>
                                <select id="payment_mode" data-pristine-required-message="{{__('validation.required', ['attribute' => strtolower(trans('system.members.payment_mode'))])}}" name="payment_mode" class="form-control" required>
                                    <option value="">{{$lbl_payment_mode}}</option>
                                    <option {{ old('payment_mode') == 'cash' ? 'selected' : '' }} value="cash">{{ trans('system.members.cash') }}</option>
                                    <option {{ old('payment_mode') == 'upi' ? 'selected' : '' }} value="upi">{{ trans('system.members.upi') }}</option>
                                </select>
                            </div>
                            @error('payment_mode')
                            <div class="pristine-error text-help">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            @php($lbl_payment_type = __('system.members.payment_type'))
                            <div class="mb-3 form-group">
                                <label class="form-label" for="payment_type">{{ $lbl_payment_type }} <span class="text-danger">*</span></label>
                                <select id="payment_type" onchange="get_paid_amount_validation(this)" data-pristine-required-message="{{__('validation.required', ['attribute' => strtolower(trans('system.members.payment_type'))])}}" name="payment_type" class="form-control" required>
                                    <option value="">{{$lbl_payment_type}}</option>
                                    <option {{ old('payment_type') == 'full' ? 'selected' : '' }} value="full">{{ trans('system.members.full') }}</option>
                                    <option {{ old('payment_type') == 'partial' ? 'selected' : '' }} value="partial">{{ trans('system.members.partial') }}</option>
                                </select>
                            </div>
                            @error('payment_type')
                            <div class="pristine-error text-help">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            @php($lbl_discount = __('system.fields.discount'))
                            <div class="mb-3 form-group @error('discount') has-danger @enderror">
                                <label class="form-label" for="discount">{{ $lbl_discount }}</label>
                                {!! html()->number('discount', old('discount')??0 )
                                ->class('form-control')
                                ->id('discount')
                                ->attribute('oninput','calculate_discount(this)')
                                ->attribute('placeholder', $lbl_discount) !!}
                                @error('discount')
                                <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-3">
                            @php($lbl_amount_paid = __('system.members.amount_paid'))
                            <div class="mb-3 form-group @error('amount_paid') has-danger @enderror">
                                <label class="form-label" for="amount_paid">{{ $lbl_amount_paid }} <span class="text-danger">*</span></label>
                                {!! html()->number('amount_paid', old('amount_paid')??0 )
                                ->class('form-control')
                                ->id('amount_paid')
                                ->attribute('oninput','calculate_pending_amount(this)')
                                ->required()
                                ->attribute('placeholder', $lbl_amount_paid) !!}
                                @error('amount_paid')
                                <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3 amount_pending_section d-none">
                            @php($lbl_amount_pending = __('system.members.amount_pending'))
                            <div class="mb-3 form-group @error('amount_pending') has-danger @enderror">
                                <label class="form-label" for="amount_pending">{{ $lbl_amount_pending }}</label>
                                {!! html()->number('amount_pending', old('amount_pending')??0 )
                                ->class('form-control')
                                ->id('amount_pending')
                                ->isReadonly()
                                ->attribute('placeholder', $lbl_amount_pending) !!}
                                @error('amount_pending')
                                <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
