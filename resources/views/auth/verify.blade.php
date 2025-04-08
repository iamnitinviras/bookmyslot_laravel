@extends('auth.layouts.app')
@section('title', __('auth.login.main_title'))
@section('content')
    <div class="auth-content my-auto">
        @if (session('resent'))
            <div class="row">
                <div class="col text-center">
                    <div class="alert alert-success" role="alert">{{ __('auth.verify_email.success') }}</div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12 text-center">
                <h5 class="mb-4">{{ __('auth.verify_email.title') }}</h5>
            </div>
            <div class="col-md-12 text-center">
                <img height="100" src="{{asset('front-images/email_verification.png')}}">
            </div>
            <div class="col-md-12 text-center">
                <p class="text-muted mt-4">{{ __('auth.verify_email.notice') }}</p>
            </div>
        </div>
        <form autocomplete="off" id="auth-resend-form" action="{{ route('verification.resend') }}" method="POST"
              class="d-none">
            @csrf
        </form>
        <div class="row">
            <div class="col text-center">
                <a id="resend-email-verification-link" class="text-capitalize" href="javascript:void(0)">
                    {{ __('auth.verify_email.another_req') }}
                </a>
            </div>
        </div>

        <form autocomplete="off" id="auth-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
        <div class="mb-3 mt-5">
            <button id="auth-logout-form-button" class="btn btn-primary w-100 waves-effect waves-light" type="button">
                <i class="mdi mdi-logout font-size-16 align-middle me-1"></i> {{ __('auth.sign_out') }}
            </button>
        </div>
    </div>
@endsection
