@extends('landing_page.app')
@section('title', trans('system.privacy_policy.privacy_policy'))
@section('content')
    <div class="breadcrumb-wrapper bg-img bg-overlay"
        style="background-image: url('{{asset('front-images/breadcum.png')}}');">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcrumb-content">
                        <h2 class="breadcrumb-title">{{ __('system.privacy_policy.privacy_policy') }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">{{trans('system.frontend.home')}}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('system.privacy_policy.privacy_policy') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-120 d-block"></div>
    <div class="saasbox-contact-us-area">
        <div class="container">
            <div class="row g-4 justify-content-between">
                <!-- Contact Form-->
                <div class="col-12 col-lg-12">
                    {!! $privacyPolicy->local_description ?? '' !!}
                </div>
            </div>
        </div>
    </div>
    <div class="mb-120 d-block"></div>
@endsection
