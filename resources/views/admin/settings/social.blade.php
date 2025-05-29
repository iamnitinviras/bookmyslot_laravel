@php($languages_array = getAllLanguages(true))
@extends('layouts.app', ['languages_array' => $languages_array])
@section('title', __('system.environment.social_settings'))
@section('content')
<div class="row">

    <div class="col-xl-12 col-sm-12">
        <div class="card">
            <div class="card-header">

                <div class="row">
                    <div class="col-md-6 col-xl-6">
                        <h4 class="card-title">{{ __('system.environment.social_settings') }}</h4>
                        <div class="page-title-box pb-0 d-sm-flex">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ url('setting') }}">{{ __('system.environment.menu') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ __('system.environment.social_settings') }}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form autocomplete="off" novalidate="" action="{{ route('admin.environment.setting.social.update') }}"
                id="pristine-valid" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @method('put')
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    {{ __('system.fields.social_media') }}
                                </div>
                                <div class="card-body">
                                    <div class="row align-items-stretch">
                                        <div class="col-md-3">
                                            @php($lbl_facebook_url = __('system.fields.facebook'))
                                            <div class="mb-3 form-group @error('facebook_url') has-danger @enderror">
                                                <label class="form-label"
                                                    for="facebook_url">{{ $lbl_facebook_url }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="fab fa-facebook-f"></i></span>
                                                    {!! html()->text('facebook_url', config('custom.facebook_url'))
    ->class('form-control')
    ->id('facebook_url')
    ->attribute('placeholder', $lbl_facebook_url)
    ->attribute('required', false) !!}
                                                </div>
                                            </div>
                                            @error('facebook_url')
                                                <div class="pristine-error text-help">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            @php($lbl_instagram_url = __('system.fields.instagram'))
                                            <div class="mb-3 form-group @error('instagram_url') has-danger @enderror">
                                                <label class="form-label"
                                                    for="instagram_url">{{ $lbl_instagram_url }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fab fa-google"></i></span>
                                                    {!! html()->text('instagram_url', config('custom.instagram_url'))
    ->class('form-control')
    ->id('instagram_url')
    ->attribute('placeholder', $lbl_instagram_url)
    ->attribute('required', false) !!}
                                                </div>
                                            </div>
                                            @error('instagram_url')
                                                <div class="pristine-error text-help">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            @php($lbl_twitter_url = __('system.fields.twitter'))
                                            <div class="mb-3 form-group @error('twitter_url') has-danger @enderror">
                                                <label class="form-label"
                                                    for="twitter_url">{{ $lbl_twitter_url }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                                    {!! html()->text('twitter_url', config('custom.twitter_url'))
    ->class('form-control')
    ->id('twitter_url')
    ->attribute('placeholder', $lbl_twitter_url)
    ->required(false) !!}
                                                </div>
                                            </div>
                                            @error('twitter_url')
                                                <div class="pristine-error text-help">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            @php($lbl_youtube_url = __('system.fields.youtube'))
                                            <div class="mb-3 form-group @error('youtube_url') has-danger @enderror">
                                                <label class="form-label"
                                                    for="youtube_url">{{ $lbl_youtube_url }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                                                    {!! html()->text('youtube_url', config('custom.youtube_url'))
    ->class('form-control')
    ->id('youtube_url')
    ->attribute('placeholder', $lbl_youtube_url)
    ->required(false) !!}
                                                </div>
                                            </div>
                                            @error('youtube_url')
                                                <div class="pristine-error text-help">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            @php($lbl_linkedin_url = __('system.fields.linkedin'))
                                            <div class="mb-3 form-group @error('linkedin_url') has-danger @enderror">
                                                <label class="form-label"
                                                    for="linkedin_url">{{ $lbl_linkedin_url }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="fab fa-linkedin"></i></span>
                                                    {!! html()->text('linkedin_url', config('custom.linkedin_url'))
    ->class('form-control')
    ->id('linkedin_url')
    ->attribute('placeholder', $lbl_linkedin_url)
    ->required(false) !!}
                                                </div>
                                            </div>
                                            @error('linkedin_url')
                                                <div class="pristine-error text-help">{{ $message }}</div>
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
