@extends('landing_page.app')
@section('title',trans('system.frontend.contact_us'))
@section('content')
    <div class="breadcrumb-wrapper bg-img bg-overlay" style="background-image: url('{{asset('front-images/breadcum.png')}}');">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcrumb-content">
                        <h2 class="breadcrumb-title">{{trans('system.frontend.contact_us')}}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">{{trans('system.frontend.home')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{trans('system.frontend.contact_us')}}</li>
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
                @if (session()->has('Success'))
                    <div class="alert alert-success alert-border-left alert-dismissible fade show success_error_alerts " role="alert">
                        <i class="mdi mdi-check-all me-3 align-middle"></i>{{session('Success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session()->has('Error'))
                    <div class="alert alert-danger alert-border-left alert-dismissible fade show success_error_alerts" role="alert">
                        <i class="mdi mdi-block-helper me-3 align-middle"></i>{{session('Error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <!-- Contact Side Info-->
                <div class="col-12 col-lg-5 col-xl-4">
                    <div class="contact-side-info mb-4 mb-md-0">
                        <p class="mb-4">{{ __('system.frontend.contact_description') }}</p>
                        <div class="contact-mini-card-wrapper">
                            <!-- Contact Mini Card-->
                            @if(config('custom.support_email')!=null)
                                <div class="contact-mini-card">
                                    <div class="contact-mini-card-icon"><i class="bi bi-envelope"></i></div>
                                    <p><a href="mailto:{{config('custom.support_email')}}">{{config('custom.support_email')}}</a></p>
                                </div>
                            @endif

                            @if(config('custom.support_phone')!=null)
                                <div class="contact-mini-card">
                                    <div class="contact-mini-card-icon"><i class="bi bi-phone"></i></div>
                                    <p><a href="tel:{{config('custom.support_phone')}}">{{config('custom.support_phone')}}</a></p>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
                <!-- Contact Form-->
                <div class="col-12 col-lg-7">
                    <div class="contact-form">
                        <form id="contactForm" action="{{ route('contactUs') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-lg-6 mb-30">
                                    <label class="form-label" for="name">{{ __('system.fields.name') }}</label>
                                    <input class="form-control" data-rule-required="true" placeholder="{{ __('system.fields.name') }}"
                                           data-msg-required="{{ __('validation.required', ['attribute' => __('system.contact_us.name')]) }}"
                                           data-rule-minlength="3"
                                           data-msg-minlength="{{ __('validation.min.numeric', ['attribute' => __('system.fields.name'), 'min' => 3]) }}" id="name" type="text" placeholder="{{ __('system.fields.name') }}" value="" name="name" required>
                                </div>
                                <div class="col-12 col-lg-6 mb-30">
                                    <label class="form-label" for="email">{{ __('system.fields.email') }}</label>
                                    {{ __('system.fields.email') }}</label>
                                    <input autocomplete="off" maxlength="50" class="form-control" id="emailAddress" name="email" type="email"
                                           data-msg-required="{{ __('validation.required', ['attribute' => __('auth.email')]) }}"
                                           data-rule-required="true" data-rule-email="true"
                                           data-msg-email="{{ __('validation.email', ['attribute' => __('auth.email')]) }}"
                                           placeholder="{{ __('system.fields.email') }}" />
                                    @if ($errors->has('email'))
                                        <span class="text-danger custom-error">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="col-12 mb-30">
                                    <label class="form-label" for="message">{{ __('system.fields.message') }}</label>
                                    <textarea class="form-control" id="message" name="message" type="text"
                                              data-msg-required="{{ __('validation.required', ['attribute' => __('system.contact_us.message')]) }}" data-rule-required="true"
                                              data-rule-minlength="5"
                                              data-msg-minlength="{{ __('validation.min.numeric', ['attribute' => __('system.contact_us.message'), 'min' => 5]) }}"
                                              placeholder="{{ __('system.fields.message') }}" style="height: 10rem;" required></textarea>
                                    @if ($errors->has('message'))
                                        <span class="text-danger custom-error">{{ $errors->first('message') }}</span>
                                    @endif
                                </div>
                                <div class="col-12 text-center">
                                    <button class="btn btn-primary w-100" type="submit">{{trans('system.crud.submit')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-120 d-block"></div>
@endsection
@push('custom-js')
    <script>
        jQuery(document).ready(function(e){
            jQuery('#contactForm').validate({
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent()).addClass('text-danger');
                },
                highlight: function(element) {
                    jQuery(element).addClass("error");
                },
                unhighlight: function(element) {
                    jQuery(element).removeClass("error");
                }
            });
        });

    </script>
@endpush
