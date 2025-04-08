<!DOCTYPE html>
@php($dir = Cookie::get('front_dir', $language->direction ?? 'ltr'))
@php($languages_array = getAllLanguages(true))
<html lang="en" dir="{{$dir}}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset(config('app.favicon_icon')) }}">
    <meta name="keywords" content="{{ config('seo_keyword') }}">
    <meta name="description" content="{{ config('seo_description') }}">
    <meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- All CSS Stylesheet-->
    <link rel="stylesheet" href="{{asset('landing_page/css/all-css-libraries.css')}}">
    <link rel="stylesheet" href="{{asset('landing_page/css/style.css')}}">
    @if(config('analytics_code')!=null)
        {!! config('analytics_code') !!}
    @endif
</head>
<body>
<!-- Preloader-->
<div class="preloader" id="preloader">
    <div class="spinner-grow text-light" role="status"><span class="visually-hidden">Loading...</span></div>
</div>
<!-- Header Area-->
<header class="header-area sticky-on">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{url('/')}}">
                <img style="width: 100%;height: 60px" src="{{ asset(config('app.logo')) }}" alt="{{ config('app.name') }}">
            </a>
            <!-- Navbar Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#saasboxNav" aria-controls="saasboxNav" aria-expanded="false" aria-label="Toggle navigation"><i
                    class="bi bi-grid"></i></button>
            <!-- Navbar Nav -->
            <div class="collapse navbar-collapse" id="saasboxNav">
                <ul class="navbar-nav navbar-nav-scroll">
                    <li><a href="{{url('/')}}">{{trans('system.frontend.home')}}</a></li>
                    <li><a href="{{url('/pricing')}}">{{trans('system.plans.pricing')}}</a></li>
                    <li><a href="{{url('/faq')}}">{{trans('system.faq.menu')}}</a></li>
                    <li><a href="{{url('/reviews')}}">{{trans('system.fields.reviews')}}</a></li>
                    <li><a href="{{url('/contact-us')}}">{{trans('system.frontend.contact_us')}}</a></li>
                </ul>
                <!-- Login Button -->
                <div class="ms-auto mb-3 mb-lg-0">
                    @if (auth()->check())
                        <a class="btn bg-white btn-sm" style="margin-right: 10px" href="{{url('/home')}}">
                            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                      d="M19,3H5C3.89,3 3,3.89 3,5V9H5V5H19V19H5V15H3V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3M10.08,15.58L11.5,17L16.5,12L11.5,7L10.08,8.41L12.67,11H3V13H12.67L10.08,15.58Z">
                                </path>
                            </svg>
                            {{ __('system.dashboard.title') }}
                        </a>
                    @else
                        <a class="btn bg-white btn-sm" style="margin-right: 10px" href="{{url('/login')}}">
                            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                      d="M19,3H5C3.89,3 3,3.89 3,5V9H5V5H19V19H5V15H3V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3M10.08,15.58L11.5,17L16.5,12L11.5,7L10.08,8.41L12.67,11H3V13H12.67L10.08,15.58Z">
                                </path>
                            </svg>
                            {{ __('auth.sign_in') }}
                        </a>
                        <a class="btn btn-warning btn-sm" href="{{url('/register')}}">
                            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                      d="M4 4V6H20V4M4 7L3 12V14H4V20H13C12.95 19.66 12.92 19.31 12.92 18.95C12.92 17.73 13.3 16.53 14 15.53V14H15.54C16.54 13.33 17.71 12.96 18.91 12.96C19.62 12.96 20.33 13.09 21 13.34V12L20 7M6 14H12V18H6M18 15V18H15V20H18V23H20V20H23V18H20V15">
                                </path>
                            </svg>
                            {{ __('auth.register_your_business') }}
                        </a>
                    @endif

                </div>
            </div>
        </div>
    </nav>
</header>
@yield('content')
<!-- Footer Area-->
<footer class="footer-area">
    <div class="container">
        <div class="copywrite-wrapper mt-5 rounded-3 d-lg-flex align-items-lg-center justify-content-lg-between">
            <!-- Copywrite Text -->
            <div class="copywrite-text text-center text-lg-start mb-3 mb-lg-0 me-lg-4">
                <p class="mb-0">{{date('Y')}} &copy; {{ __('auth.all_rights_reserved') }}</a></p>
            </div>
            <!-- Footer Nav -->
            <div class="footer-nav mb-3 mb-lg-0 me-lg-4">
                <ul class="mb-0 d-flex flex-wrap justify-content-center list-unstyled">
                    <li><a href="{{url('/privacy-policy')}}">{{ trans('system.frontend.privacy_policy') }}</a></li>
                    <li><a href="{{url('/terms-and-condition')}}">{{ trans('system.frontend.terms_and_condition') }}</a></li>
                    <li><a href="{{url('/contact-us')}}">{{ trans('system.frontend.contact_us') }}</a></li>
                </ul>
            </div>
            <!-- Dropup -->

            @if(isset($languages_array) && count($languages_array)>1)
                <div class="language-dropdown text-center text-lg-end">
                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"> {{__('system.languages.title')}}</button>
                    <div class="dropdown-menu dropdown-menu-end">
                        @foreach ($languages_array as $key => $language)
                            <a class="dropdown-item" @if (App::currentLocale() != $key) onclick="event.preventDefault(); document.getElementById('user_set_default_language{{ $key }}').submit();"
                               @endif  href="javascript:void(0)">{{$language}} @if (App::currentLocale() == $key)
                                    <i class="bi bi-check"></i>
                                @endif</a>
                            @if (App::currentLocale() != $key)
                                {{ Form::open(['route' => ['admin.default.language', ['language' => $key]], 'method' => 'put', 'autocomplete' => 'off', 'class' => 'd-none', 'id' => 'user_set_default_language' . $key]) }}
                                <input type="hidden" name='back' value="{{ request()->fullurl() }}">
                                {{ Form::close() }}
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif


        </div>
        <div class="footer-social-icon d-flex align-items-center mt-3 justify-content-center">

            @if(config('app.facebook_url')!=null)
                <a target="_blank" href="{{config('app.facebook_url')}}">
                    <i class="bi bi-facebook"></i>
                </a>
            @endif

            @if(config('app.twitter_url')!=null)
                <a target="_blank" href="{{config('app.twitter_url')}}">
                    <i class="bi bi-twitter"></i>
                </a>
            @endif
            @if(config('app.instagram_url')!=null)
                <a target="_blank" href="{{config('app.instagram_url')}}">
                    <i class="bi bi-instagram"></i>
                </a>
            @endif
            @if(config('app.linkedin_url')!=null)
                <a target="_blank" href="{{config('app.linkedin_url')}}">
                    <i class="bi bi-linkedin"></i>
                </a>
            @endif
            @if(config('app.youtube_url')!=null)
                <a target="_blank" href="{{config('app.youtube_url')}}">
                    <i class="bi bi-youtube"></i>
                </a>
            @endif
        </div>
    </div>
</footer>
<!-- Scroll To Top  -->
<div id="scrollTopButton"><i class="bi bi-arrow-up-short"></i></div>
<div class="mb-5 d-block"></div>
<!-- All JavaScript Files-->
<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}" type="text/javascript"></script>
<script src="{{asset('landing_page/js/all-js-libraries.js')}}"></script>
<script src="{{asset('landing_page/js/active.js')}}"></script>
<script src="{{ asset('assets/libs/jquery-validation/jquery.validate.min.js') }}"></script>
@stack('custom-js')
</body>
</html>
