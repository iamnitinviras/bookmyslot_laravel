@php($languages_array = getAllLanguages(true))
@extends('layouts.app', ['languages_array' => $languages_array])
@section('title', __('system.environment.recaptcha'))
@section('content')
    <div class="row">

        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('system.environment.recaptcha') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.environment.recaptcha') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form autocomplete="off" novalidate="" action="{{ route('admin.environment.recaptcha.update') }}" id="pristine-valid" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('environment/setting') }}">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">{{ __('system.environment.application') }}
                                                {{ __('system.environment.title') }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('environment/setting/email') }}">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">{{ __('system.environment.email') }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('environment/setting/payment') }}">
                                            <span class="d-block d-sm-none"><i class="far fa-credit-card"></i></span>
                                            <span class="d-none d-sm-block">{{ __('system.environment.payment') }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.frontend.admin') }}">
                                            <span class="d-block d-sm-none"><i class="fa fa-globe"></i></span>
                                            <span class="d-none d-sm-block">{{ __('system.dashboard.frontend') }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if(request()->route()->getName()=='admin.environment.recaptcha') active @endif" href="{{ url('environment/setting/recaptcha') }}">
                                            <span class="d-block d-sm-none"><i class="fa fa-code"></i></span>
                                            <span class="d-none d-sm-block">{{ __('system.environment.recaptcha') }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('environment/setting/seo') }}">
                                            <span class="d-block d-sm-none"><i class="fa fa-code"></i></span>
                                            <span class="d-none d-sm-block">{{ __('system.environment.seo') }}</span>
                                        </a>
                                    </li>
                                </ul>
                                @method('put')
                                @csrf
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                @php($enable_captcha=old('enable_recaptcha',config('custom.enable_captcha')))
                                                @php($nocaptcha_secret=old('nocaptcha_secret',config('custom.nocaptcha_secret')))
                                                @php($nocaptcha_sitekey=old('nocaptcha_sitekey',config('custom.nocaptcha_sitekey')))
                                                <div class="mb-3 form-group @error('status') has-danger @enderror  @error('status') has-danger @enderror">
                                                    <label class="form-label w-100" for="name">{{trans('system.environment.enable_recaptcha')}}</label>
                                                    <div class="form-check form-check-inline">
                                                        <input @if($enable_captcha=='1') checked @endif onclick="recaptcha_enable(this)" class="form-check-input" type="radio" name="enable_recaptcha"
                                                               id="enable_recaptcha_yes" value="1">
                                                        <label class="form-check-label" for="enable_recaptcha_yes">{{trans('system.crud.yes')}}</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input @if($enable_captcha=='0') checked @endif onclick="recaptcha_enable(this)" class="form-check-input" type="radio" name="enable_recaptcha"
                                                               id="enable_recaptcha_no" value="0">
                                                        <label class="form-check-label" for="enable_recaptcha_no">{{trans('system.crud.no')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row @if($enable_captcha=='0') d-none @endif" id="enable_captcha_section">
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="col-lg-12 mb-3">
                                                            <div class="form-group">
                                                                <label class="text-label">{{ trans('system.environment.nocaptcha_secret') }}</label>
                                                                <input
                                                                    data-pristine-required-message="{{ __('validation.required', ['attribute' => strtolower(trans('system.environment.nocaptcha_secret'))]) }}"
                                                                    value="{{ old('nocaptcha_secret',$nocaptcha_secret??'')}}"
                                                                    type="text"
                                                                    id="nocaptcha_secret"
                                                                    name="nocaptcha_secret"
                                                                    class="form-control"
                                                                    @if($enable_captcha=='1') required @endif
                                                                    placeholder="{{ trans('system.environment.nocaptcha_secret') }}">
                                                                @error('nocaptcha_secret')
                                                                <div class="pristine-error text-help">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12 mb-3">
                                                            <div class="form-group">
                                                                <label class="text-label">{{ trans('system.environment.nocaptcha_sitekey') }}</label>
                                                                <input
                                                                    data-pristine-required-message="{{ __('validation.required', ['attribute' => strtolower(trans('system.environment.nocaptcha_sitekey'))]) }}"
                                                                    value="{{ old('nocaptcha_sitekey',$nocaptcha_sitekey??'')}}"
                                                                    type="text"
                                                                    name="nocaptcha_sitekey"
                                                                    id="nocaptcha_sitekey"
                                                                    class="form-control"
                                                                    @if($enable_captcha=='1') required @endif
                                                                    placeholder="{{ trans('system.environment.nocaptcha_sitekey') }}">
                                                                @error('nocaptcha_sitekey')
                                                                <div class="pristine-error text-help">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        @php($enable_captcha_on_suggestion=old('enable_captcha_on_suggestion',config('custom.enable_captcha_on_suggestion')))
                                                        @php($enable_captcha_on_comments=old('enable_captcha_on_comments',config('custom.enable_captcha_on_comments')))
                                                        @php($enable_captcha_on_contact_us=old('enable_captcha_on_contact_us',config('custom.enable_captcha_on_contact_us')))
                                                        @php($enable_captcha_on_support_request=old('enable_captcha_on_support_request',config('custom.enable_captcha_on_support_request')))
                                                        <div class="mb-3 form-group @error('status') has-danger @enderror  @error('status') has-danger @enderror">
                                                            <label class="form-label w-100" for="name">{{trans('system.environment.enable_captcha_on_suggestion')}}</label>
                                                            <div class="form-check form-check-inline">
                                                                <input @if($enable_captcha_on_suggestion=='1') checked @endif class="form-check-input" type="radio" name="enable_captcha_on_suggestion"
                                                                       id="enable_captcha_on_suggestion_yes" value="1">
                                                                <label class="form-check-label" for="enable_captcha_on_suggestion_yes">{{trans('system.crud.yes')}}</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input @if($enable_captcha_on_suggestion=='0') checked @endif class="form-check-input" type="radio" name="enable_captcha_on_suggestion"
                                                                       id="enable_captcha_on_suggestion_no" value="0">
                                                                <label class="form-check-label" for="enable_captcha_on_suggestion_no">{{trans('system.crud.no')}}</label>
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="mb-3 form-group @error('enable_captcha_on_comments') has-danger @enderror  @error('enable_captcha_on_comments') has-danger @enderror">
                                                            <label class="form-label w-100" for="name">{{trans('system.environment.enable_captcha_on_comments')}}</label>
                                                            <div class="form-check form-check-inline">
                                                                <input @if($enable_captcha_on_comments=='1') checked @endif class="form-check-input" type="radio" name="enable_captcha_on_comments"
                                                                       id="enable_captcha_on_comments_yes" value="1">
                                                                <label class="form-check-label" for="enable_captcha_on_comments_yes">{{trans('system.crud.yes')}}</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input @if($enable_captcha_on_comments=='0') checked @endif class="form-check-input" type="radio" name="enable_captcha_on_comments"
                                                                       id="enable_captcha_on_comments_no" value="0">
                                                                <label class="form-check-label" for="enable_captcha_on_comments_no">{{trans('system.crud.no')}}</label>
                                                            </div>
                                                        </div>


                                                        <div
                                                            class="mb-3 form-group @error('enable_captcha_on_contact_us') has-danger @enderror  @error('enable_captcha_on_contact_us') has-danger @enderror">
                                                            <label class="form-label w-100" for="enable_captcha_on_contact_us_yes">{{trans('system.environment.enable_captcha_on_contact_us')}}</label>
                                                            <div class="form-check form-check-inline">
                                                                <input @if($enable_captcha_on_contact_us=='1') checked @endif class="form-check-input" type="radio" name="enable_captcha_on_contact_us"
                                                                       id="enable_captcha_on_contact_us_yes" value="1">
                                                                <label class="form-check-label" for="enable_captcha_on_contact_us_yes">{{trans('system.crud.yes')}}</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input @if($enable_captcha_on_contact_us=='0') checked @endif class="form-check-input" type="radio" name="enable_captcha_on_contact_us"
                                                                       id="enable_captcha_on_contact_us_no" value="0">
                                                                <label class="form-check-label" for="enable_captcha_on_contact_us_no">{{trans('system.crud.no')}}</label>
                                                            </div>
                                                        </div>


                                                        <div
                                                            class="mb-3 form-group @error('enable_captcha_on_support_request') has-danger @enderror  @error('enable_captcha_on_support_request') has-danger @enderror">
                                                            <label class="form-label w-100" for="enable_captcha_on_support_request_yes">{{trans('system.environment.enable_captcha_on_support_request')}}</label>
                                                            <div class="form-check form-check-inline">
                                                                <input @if($enable_captcha_on_support_request=='1') checked @endif class="form-check-input" type="radio" name="enable_captcha_on_support_request"
                                                                       id="enable_captcha_on_support_request_yes" value="1">
                                                                <label class="form-check-label" for="enable_captcha_on_support_request_yes">{{trans('system.crud.yes')}}</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input @if($enable_captcha_on_support_request=='0') checked @endif class="form-check-input" type="radio" name="enable_captcha_on_support_request"
                                                                       id="enable_captcha_on_support_request_no" value="0">
                                                                <label class="form-check-label" for="enable_captcha_on_support_request_no">{{trans('system.crud.no')}}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-12 mt-1">
                                                <button class="btn btn-primary" type="submit">{{ __('system.crud.save') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- end card -->
            </div>
        </div>
    </div>
@endsection
