<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 ">
                @php($lbl_app_name = __('system.fields.app_name'))
                <div class="mb-3 form-group @error('app_name') has-danger @enderror">
                    <label class="form-label" for="app_name">{{ $lbl_app_name }} <span class="text-danger">*</span></label>
                    {!! html()->text('app_name', config('app.name'))
                    ->class('form-control')
                    ->id('app_name')
                    ->required()
                    ->attribute('placeholder', $lbl_app_name)
                    ->attribute('maxlength', 50)
                    ->attribute('minlength', 1)
                    ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_app_name)]))
                    ->attribute('data-pristine-pattern-message', __('validation.custom.invalid', ['attribute' => strtolower($lbl_app_name)]))
                    ->attribute('data-pristine-minlength-message', __('validation.custom.invalid', ['attribute' => strtolower($lbl_app_name)])) !!}

                    @error('app_name')
                    <div class="pristine-error text-help">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                @php($lbl_app_currency = __('system.fields.select_app_currency'))
                <div class="mb-3 form-group @error('app_currency') has-danger @enderror">
                    <label class="form-label" for="input-app_currency">{{ $lbl_app_currency }} <span class="text-danger">*</span></label>
                    {!! html()->select('app_currency', getAllCurrencies(), config('custom.currency'))
                    ->class('form-select choice-picker')
                    ->id('input-app_currency')
                    ->attribute('data-remove_attr', 'data-type')
                    ->required() !!}
                    @error('app_currency')
                    <div class="pristine-error text-help">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                @php($lbl_currency_position = __('system.fields.currency_position'))

                <div class="mb-3 form-group @error('currency_position') has-danger @enderror">
                    <label class="form-label" for="input-currency_position">{{ $lbl_currency_position }} <span class="text-danger">*</span></label>
                    {!! html()->select('currency_position', [
                            'left' => 'left',
                            'right' => 'right'
                        ], config('custom.currency_position'))
                        ->class('form-control form-select')
                        ->id('input-currency_position')
                        ->required() !!}
                    @error('currency_position')
                    <div class="pristine-error text-help">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 ">
                @php($lbl_support_email = __('system.fields.support_email'))
                <div class="mb-3 form-group @error('support_email') has-danger @enderror">
                    <label class="form-label" for="app_name">{{ $lbl_support_email }} <span class="text-danger">*</span></label>
                    {!! html()->email('support_email', config('custom.support_email'))
                    ->class('form-control')
                    ->id('support_email')
                    ->attribute('placeholder', $lbl_support_email)
                    ->required()
                    ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_support_email)])) !!}
                    @error('support_email')
                    <div class="pristine-error text-help">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-3 ">
                @php($lbl_support_phone = __('system.fields.support_phone'))
                <div class="mb-3 form-group @error('support_phone') has-danger @enderror">
                    <label class="form-label" for="support_phone">{{ $lbl_support_phone }} <span class="text-danger">*</span></label>
                    {!! html()->text('support_phone', config('custom.support_phone'))
                    ->class('form-control')
                    ->id('support_phone')
                    ->attribute('placeholder', $lbl_support_phone)
                    ->required()
                    ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_support_phone)])) !!}
                    @error('support_email')
                    <div class="pristine-error text-help">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">{{ __('system.fields.app_date_time_settings') }}</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                @php($lbl_app_timezone = __('system.fields.app_timezone'))
                <div class="mb-3 form-group @error('app_timezone') has-danger @enderror">
                    <label class="form-label" for="input-app_timezone">{{ $lbl_app_timezone }} <span class="text-danger">*</span></label>
                    {!! html()->select('app_timezone', \App\Http\Controllers\Admin\EnvSettingController::GetTimeZones(), config('custom.timezone'))
                    ->class('form-select choice-picker')
                    ->id('input-app_timezone')
                    ->required()
                    ->attribute('data-remove_attr', 'data-type') !!}
                    @error('app_timezone')
                    <div class="pristine-error text-help">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                @php($lbl_app_date_time_format = __('system.fields.app_date_time_format'))

                <div class="mb-3 form-group @error('app_date_time_format') has-danger @enderror">
                    <label class="form-label" for="input-app_date_time_format">{{ $lbl_app_date_time_format }} <span class="text-danger">*</span></label>
                    {!! html()->select('app_date_time_format', App\Http\Controllers\Admin\EnvSettingController::GetDateFormat(), config('custom.date_time_format'))
                    ->class('form-control form-select')
                    ->id('input-app_date_time_format')
                    ->required() !!}
                    @error('app_date_time_format')
                    <div class="pristine-error text-help">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="text-left">
            <h5>{{ __('system.fields.social_media') }}</h5>
        </div>
    </div>
    <div class="card-body">
        <div class="row align-items-stretch">
            <div class="col-md-3">
                @php($lbl_facebook_url = __('system.fields.facebook'))
                <div class="mb-3 form-group @error('facebook_url') has-danger @enderror">
                    <label class="form-label" for="facebook_url">{{ $lbl_facebook_url }}</label>
                    {!! html()->text('facebook_url', config('custom.facebook_url'))
                    ->class('form-control')
                    ->id('facebook_url')
                    ->attribute('placeholder', $lbl_facebook_url)
                    ->attribute('required', false) !!}
                </div>
                @error('facebook_url')
                <div class="pristine-error text-help">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                @php($lbl_instagram_url = __('system.fields.instagram'))
                <div class="mb-3 form-group @error('instagram_url') has-danger @enderror">
                    <label class="form-label" for="instagram_url">{{ $lbl_instagram_url }}</label>
                    {!! html()->text('instagram_url', config('custom.instagram_url'))
                    ->class('form-control')
                    ->id('instagram_url')
                    ->attribute('placeholder', $lbl_instagram_url)
                    ->attribute('required', false) !!}
                </div>
                @error('instagram_url')
                <div class="pristine-error text-help">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                @php($lbl_twitter_url = __('system.fields.twitter'))
                <div class="mb-3 form-group @error('twitter_url') has-danger @enderror">
                    <label class="form-label" for="twitter_url">{{ $lbl_twitter_url }}</label>
                    {!! html()->text('twitter_url', config('custom.twitter_url'))
                    ->class('form-control')
                    ->id('twitter_url')
                    ->attribute('placeholder', $lbl_twitter_url)
                    ->required(false) !!}
                </div>
                @error('twitter_url')
                <div class="pristine-error text-help">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                @php($lbl_youtube_url = __('system.fields.youtube'))
                <div class="mb-3 form-group @error('youtube_url') has-danger @enderror">
                    <label class="form-label" for="youtube_url">{{ $lbl_youtube_url }}</label>
                    {!! html()->text('youtube_url', config('custom.youtube_url'))
                    ->class('form-control')
                    ->id('youtube_url')
                    ->attribute('placeholder', $lbl_youtube_url)
                    ->required(false) !!}
                </div>
                @error('youtube_url')
                <div class="pristine-error text-help">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                @php($lbl_linkedin_url = __('system.fields.linkedin'))
                <div class="mb-3 form-group @error('linkedin_url') has-danger @enderror">
                    <label class="form-label" for="linkedin_url">{{ $lbl_linkedin_url }}</label>
                    {!! html()->text('linkedin_url', config('custom.linkedin_url'))
                    ->class('form-control')
                    ->id('linkedin_url')
                    ->attribute('placeholder', $lbl_linkedin_url)
                    ->required(false) !!}
                </div>
                @error('linkedin_url')
                <div class="pristine-error text-help">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-header">
        <h5 class="mb-0">{{ __('system.fields.media') }}</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 form-group">
                @php($lbl_app_logo= __('system.fields.logo'))
                <label class="form-label d-block" for="app_name">{{ $lbl_app_logo }} <span class="text-danger">*</span></label>
                <div class="d-flex align-items-center ">
                    <div class='mx-3 '>
                        <img src="{{ asset(config('custom.logo')) }}" alt="" class=" preview-image avater-120-contain">
                    </div>
                </div>
                <input type="file" name="app_dark_logo" id="app_dark_logo" class="d-none my-preview" accept="image/*"
                       data-pristine-accept-message="{{ __('validation.enum', ['attribute' => strtolower($lbl_app_logo)]) }}" data-preview='.preview-image'>
                <label for="app_dark_logo" class="mb-0">
                    <div for="profile-image" class="btn btn-outline-primary waves-effect waves-light my-2 mdi mdi-upload ">
                        <span class="d-none d-lg-inline">{{ $lbl_app_logo }}</span>
                    </div>
                </label>
                @error('app_dark_logo')
                <div class="pristine-error text-help px-3">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4 form-group">
                @php($lbl_app_favicon_logo = __('system.fields.app_favicon_logo'))
                <label class="form-label d-block" for="app_name">{{ $lbl_app_favicon_logo }} <span class="text-danger">*</span></label>
                <div class="d-flex align-items-center ">
                    <div class='mx-3 '>
                        <img src="{{ asset(config('custom.favicon_icon')) }}" alt="" class="avatar-xl  preview-image_21 avater-120-contain">
                    </div>
                </div>
                <input type="file" name="app_favicon_logo" id="app_favicon_logo" class="d-none my-preview" accept="image/*"
                       data-pristine-accept-message="{{ __('validation.enum', ['attribute' => strtolower($lbl_app_favicon_logo)]) }}" data-preview='.preview-image_21'>
                <label for="app_favicon_logo" class="mb-0">
                    <div for="profile-image" class="btn btn-outline-primary waves-effect waves-light my-2 mdi mdi-upload ">
                        <span class="d-none d-lg-inline"> {{ $lbl_app_favicon_logo }} </span>
                    </div>
                </label>
                @error('app_favicon_logo')
                <div class="pristine-error text-help px-3">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>








