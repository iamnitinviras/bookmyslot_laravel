@php($languages_array = getAllLanguages(true))
@extends('layouts.app', ['languages_array' => $languages_array])
@section('title', __('system.environment.email'))
@section('content')
    <div class="row">

        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('system.environment.email') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ url('setting') }}">{{ __('system.environment.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.environment.email') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form autocomplete="off" novalidate="" action="{{ route('admin.environment.setting.email.update') }}" id="pristine-valid" method="post" enctype="multipart/form-data">
                                @method('put')
                                @csrf
                                <div class="card">
                                    <div class="card-header">
                                        {{trans('system.environment.email_configuration')}}
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                @php($lbl_app_smtp_from_address = __('system.fields.app_smtp_from_address'))
                                                <div class="mb-3 form-group @error('app_smtp_from_address') has-danger @enderror">
                                                    <label class="form-label" for="app_smtp_from_address">{{ $lbl_app_smtp_from_address }} <span class="text-danger">*</span></label>
                                                    {!! html()->email('app_smtp_from_address', config('mail.from.address'))
                                                    ->class('form-control')
                                                    ->id('app_smtp_from_address')
                                                    ->placeholder($lbl_app_smtp_from_address)
                                                    ->required()
                                                    ->attribute('maxlength', 50)
                                                    ->attribute('minlength', 2)
                                                    ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_app_smtp_from_address)]))
                                                    ->attribute('data-pristine-email-message', __('validation.custom.invalid', ['attribute' => strtolower($lbl_app_smtp_from_address)]))
                                                    ->attribute('data-pristine-minlength-message', __('validation.custom.invalid', ['attribute' => strtolower($lbl_app_smtp_from_address)])) !!}

                                                    @error('app_smtp_from_address')
                                                    <div class="pristine-error text-help">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                @php($lbl_app_smtp_host = __('system.fields.app_smtp_host'))

                                                <div class="mb-3 form-group @error('app_smtp_host') has-danger @enderror">
                                                    <label class="form-label" for="input-app_smtp_host">{{ $lbl_app_smtp_host }} <span class="text-danger">*</span></label>
                                                    {!! html()->text('app_smtp_host', config('mail.mailers.smtp.host'))
                                                    ->class('form-control')
                                                    ->id('input-app_smtp_host')
                                                    ->required() !!}


                                                    @error('app_smtp_host')
                                                    <div class="pristine-error text-help">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                @php($lbl_app_smtp_port = __('system.fields.app_smtp_port'))

                                                <div class="mb-3 form-group @error('app_smtp_port') has-danger @enderror">
                                                    <label class="form-label" for="input-app_smtp_port">{{ $lbl_app_smtp_port }} <span class="text-danger">*</span></label>
                                                    {!! html()->select('app_smtp_port', [
                                                        '25' => 25,
                                                        '465' => 465,
                                                        '587' => 587,
                                                        '2525' => 2525
                                                    ], config('mail.mailers.smtp.port'))
                                                    ->class('form-control form-select')
                                                    ->id('input-app_smtp_port')
                                                    ->required() !!}


                                                    @error('app_smtp_port')
                                                    <div class="pristine-error text-help">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                @php($lbl_app_smtp_encryption = __('system.fields.app_smtp_encryption'))

                                                <div class="mb-3 form-group @error('app_smtp_encryption') has-danger @enderror">
                                                    <label class="form-label" for="input-app_smtp_encryption">{{ $lbl_app_smtp_encryption }} <span class="text-danger">*</span></label>
                                                    {!! html()->select('app_smtp_encryption', [
                                                        'ssl' => 'ssl',
                                                        'tls' => 'tls',
                                                        'STARTTLS' => 'STARTTLS'
                                                    ], config('mail.mailers.smtp.encryption'))
                                                    ->class('form-control form-select')
                                                    ->id('input-app_smtp_encryption')
                                                    ->required() !!}


                                                    @error('app_smtp_encryption')
                                                    <div class="pristine-error text-help">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                @php($lbl_app_smtp_username = __('system.fields.app_smtp_username'))
                                                <div class="mb-3 form-group @error('app_smtp_username') has-danger @enderror">
                                                    <label class="form-label" for="app_smtp_username">{{ $lbl_app_smtp_username }} <span class="text-danger">*</span></label>
                                                    {!! html()->text('app_smtp_username', config('mail.mailers.smtp.username'))
                                                    ->class('form-control pristine-custom-pattern')
                                                    ->id('app_smtp_username')
                                                    ->placeholder($lbl_app_smtp_username)
                                                    ->required()
                                                    ->attribute('custom-pattern', '^((?!\${.*}).)*$')
                                                    ->maxlength(50)
                                                    ->minlength(2)
                                                    ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_app_smtp_username)]))
                                                    ->attribute('data-pristine-pattern-message', __('validation.custom.invalid', ['attribute' => strtolower($lbl_app_smtp_username)]))
                                                    ->attribute('data-pristine-minlength-message', __('validation.custom.invalid', ['attribute' => strtolower($lbl_app_smtp_username)])) !!}

                                                    @error('app_smtp_username')
                                                    <div class="pristine-error text-help">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                @php($lbl_app_smtp_password = __('system.fields.app_smtp_password'))
                                                <div class="mb-3 form-group @error('app_smtp_password') has-danger @enderror">
                                                    <label class="form-label" for="app_smtp_password">{{ $lbl_app_smtp_password }} <span class="text-danger">*</span></label>
                                                    <input class="form-control pristine-custom-pattern" id="app_smtp_password" placeholder="Password" required="true" minlength="2"
                                                           custom-pattern='^((?!\${.*}).)*$'
                                                           data-pristine-required-message="{{ __('validation.required', ['attribute' => strtolower($lbl_app_smtp_password)]) }}"
                                                           data-pristine-pattern-message="{{ __('validation.custom.invalid', ['attribute' => strtolower($lbl_app_smtp_password)]) }}"
                                                           data-pristine-minlength-message="{{ __('validation.custom.invalid', ['attribute' => strtolower($lbl_app_smtp_password)]) }}"
                                                           name="app_smtp_password" type="password" value="{{ config('mail.mailers.smtp.password') }}">
                                                    @error('app_smtp_username')
                                                    <div class="pristine-error text-help">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent border-top text-muted">
                                        <div class="row">
                                            <div class="col-12 mt-1">
                                                <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> {{ __('system.crud.save') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12">
                            <form autocomplete="off" novalidate="" action="{{ route('admin.environment.setting.email.test') }}" class="custom_form_validation" method="post">
                                @method('put')
                                @csrf
                                <div class="card">
                                    <div class="card-header">
                                        {{trans('system.environment.test_email')}}
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                @php($lbl_email = __('system.fields.email'))
                                                <div class="mb-3 form-group @error('app_smtp_from_address') has-danger @enderror">
                                                    <label class="form-label" for="app_smtp_from_address">{{ $lbl_email }} <span class="text-danger">*</span></label>
                                                    {!! html()->email('test_email')
                                                        ->class('form-control')
                                                        ->id('test_email')
                                                        ->placeholder($lbl_email)
                                                        ->required()
                                                        ->maxlength(50)
                                                        ->minlength(2)
                                                        ->attribute('data-pristine-required-message', __('validation.required', ['attribute' => strtolower($lbl_email)])) !!}
                                                    @error('test_email')
                                                        <div class="pristine-error text-help">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn mt-4 btn-primary" type="submit"><i class="fa fa-envelope"></i> {{ __('system.environment.send_email') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end card -->
            </div>
        </div>
    </div>
@endsection
