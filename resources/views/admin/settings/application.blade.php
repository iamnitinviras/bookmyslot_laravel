@php($languages_array = getAllLanguages(true))
@extends('layouts.app', ['languages_array' => $languages_array])
@section('title', __('system.environment.menu'))
@section('content')
<div class="row">
    <div class="col-xl-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6 col-xl-6">
                        <h4 class="card-title">{{ __('system.environment.application') }}
                            {{ __('system.environment.title') }}
                        </h4>
                        <div class="page-title-box pb-0 d-sm-flex">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a
                                            href="{{ url('setting') }}">{{ __('system.environment.menu') }}</a></li>
                                    <li class="breadcrumb-item active">{{ __('system.environment.application') }}
                                        {{ __('system.environment.title') }}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form autocomplete="off" novalidate="" action="{{ route('admin.environment.setting.update') }}"
                id="pristine-valid" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @method('put')
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 ">
                                            @php($lbl_app_name = __('system.fields.app_name'))
                                            <div class="mb-3 form-group @error('app_name') has-danger @enderror">
                                                <label class="form-label" for="app_name">{{ $lbl_app_name }} <span
                                                        class="text-danger">*</span></label>
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
                                            @php($lbl_app_currency = __('system.payment_setting.select_app_currency'))
                                            <div class="mb-3 form-group @error('app_currency') has-danger @enderror">
                                                <label class="form-label"
                                                    for="input-app_currency">{{ $lbl_app_currency }} <span
                                                        class="text-danger">*</span></label>
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

                                            <div
                                                class="mb-3 form-group @error('currency_position') has-danger @enderror">
                                                <label class="form-label"
                                                    for="input-currency_position">{{ $lbl_currency_position }} <span
                                                        class="text-danger">*</span></label>
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
                                                <label class="form-label" for="app_name">{{ $lbl_support_email }} <span
                                                        class="text-danger">*</span></label>
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
                                                <label class="form-label" for="support_phone">{{ $lbl_support_phone }}
                                                    <span class="text-danger">*</span></label>
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
                                                <label class="form-label"
                                                    for="input-app_timezone">{{ $lbl_app_timezone }} <span
                                                        class="text-danger">*</span></label>
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

                                            <div
                                                class="mb-3 form-group @error('app_date_time_format') has-danger @enderror">
                                                <label class="form-label"
                                                    for="input-app_date_time_format">{{ $lbl_app_date_time_format }}
                                                    <span class="text-danger">*</span></label>
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
                                    <h5 class="mb-0">{{ __('system.fields.media') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            @php($lbl_app_logo = __('system.fields.logo'))
                                            <label class="form-label d-block" for="app_name">{{ $lbl_app_logo }} <span
                                                    class="text-danger">*</span></label>
                                            <div class="d-flex align-items-center ">
                                                <div class='mx-3 '>
                                                    <img src="{{ asset(config('custom.logo')) }}" alt=""
                                                        class=" preview-image avater-120-contain">
                                                </div>
                                            </div>
                                            <input type="file" name="app_dark_logo" id="app_dark_logo"
                                                class="d-none my-preview" accept="image/*"
                                                data-pristine-accept-message="{{ __('validation.enum', ['attribute' => strtolower($lbl_app_logo)]) }}"
                                                data-preview='.preview-image'>
                                            <label for="app_dark_logo" class="mb-0">
                                                <div for="profile-image"
                                                    class="btn btn-outline-primary waves-effect waves-light my-2 mdi mdi-upload ">
                                                    <span class="d-none d-lg-inline">{{ $lbl_app_logo }}</span>
                                                </div>
                                            </label>
                                            @error('app_dark_logo')
                                                <div class="pristine-error text-help px-3">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 form-group">
                                            @php($lbl_app_favicon_logo = __('system.fields.app_favicon_logo'))
                                            <label class="form-label d-block" for="app_name">{{ $lbl_app_favicon_logo }}
                                                <span class="text-danger">*</span></label>
                                            <div class="d-flex align-items-center ">
                                                <div class='mx-3 '>
                                                    <img src="{{ asset(config('custom.favicon_icon')) }}" alt=""
                                                        class="avatar-xl  preview-image_21 avater-120-contain">
                                                </div>
                                            </div>
                                            <input type="file" name="app_favicon_logo" id="app_favicon_logo"
                                                class="d-none my-preview" accept="image/*"
                                                data-pristine-accept-message="{{ __('validation.enum', ['attribute' => strtolower($lbl_app_favicon_logo)]) }}"
                                                data-preview='.preview-image_21'>
                                            <label for="app_favicon_logo" class="mb-0">
                                                <div for="profile-image"
                                                    class="btn btn-outline-primary waves-effect waves-light my-2 mdi mdi-upload ">
                                                    <span class="d-none d-lg-inline"> {{ $lbl_app_favicon_logo }}
                                                    </span>
                                                </div>
                                            </label>
                                            @error('app_favicon_logo')
                                                <div class="pristine-error text-help px-3">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top text-muted">
                    <div class="row">
                        <div class="col-12 mt-1">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>
                                {{ __('system.crud.save') }}</button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- end card -->
        </div>
    </div>
</div>
@endsection
