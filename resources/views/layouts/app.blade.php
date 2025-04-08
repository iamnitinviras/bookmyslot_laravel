<!doctype html>
@php($dir = Cookie::get('front_dir', $language->direction ?? 'ltr'))
<html lang="en" dir="{{$dir}}">
@php($metaDatas = getSiteSetting())
<head>
    <meta charset="utf-8"/>
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{ asset(config('custom.favicon_icon')) }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/preloader.min.css') }}" type="text/css"/>
    @if($dir=='rtl')
        <link href="{{ asset('assets/admin/css/bootstrap-rtl.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css"/>
    @else
        <link href="{{ asset('assets/admin/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css"/>
    @endif
    <link href="{{ asset('assets/admin/css/icons.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/admin/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/admin/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/admin/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/admin/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/admin/libs/alertifyjs/build/css/alertify.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/admin/libs/alertifyjs/build/css/themes/default.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/admin/css/custom.css') }}" rel="stylesheet" type="text/css"/>
    @if($dir=='rtl')
        <link rel="stylesheet" href="{{ asset('assets/admin/css/app-rtl.min.css') }}" type="text/css"/>
    @endif
    <link rel="stylesheet" href="{{ asset('assets/admin/cdns/intlTelInput.css') }}"/>
    @stack('third_party_stylesheets')
    <style>
        .iti__flag {
            background-image: url("{{ asset('assets/admin/cdns/flags.png') }}");
        }
    </style>
    @stack('page_css')
    @if(isset($metaDatas['analytics_code']) && $metaDatas['analytics_code']!=null && $metaDatas['analytics_code']!="")
        {!! $metaDatas['analytics_code'] !!}
    @endif
</head>
@php($theme = Cookie::get('resto_defult_theme', 'light'))
<body @hasanyrole('staff|vendor') data-topbar="dark" data-layout="horizontal" @endhasanyrole data-topbar="{{ $theme }}">
<div id="layout-wrapper">

    @hasanyrole('Super-Admin')
    @include('layouts.vertical')
    @endhasanyrole

    @hasanyrole('staff|vendor')
    @include('layouts.horizontal')
    @endhasanyrole

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
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
                @if (!auth()->user()->hasVerifiedEmail())
                    @include('layouts.verify')
                @endif
                @yield('content')
            </div>
        </div>

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <p class="mb-0">©
                            <script>
                                document.write(new Date().getFullYear())
                            </script> {{ __('auth.copyright') }}
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                            <a href="{{ route('/') }}">{{ config('app.name') }}</a>
                            | {{ __('auth.all_rights_reserved') }}
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <div class="modal fade bs-example-modal-xl" id="search-model" data-bs-focus="false" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-modal="true" role="dialog">

        <div class="modal-dialog modal-xl ">
            <div class="modal-content">
                <div class="modal-header">
                    <form class="app-search d-block w-100 mt-3" id="global-search-form" autocomplete="off">
                        @csrf
                        <div class="position-relative">
                            <input type="text" class="form-control global-search-input" id="global-search-input" name='search' tabindex="2" placeholder="{{ __('system.crud.search') }}" autofocus>
                            <button class="btn btn-primary global-search-btn" type="button"><i class="bx bx-search-alt align-middle"></i></button>
                        </div>
                    </form>
                    <button type="button" class="btn-close position-absolute model-top-close-css" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body search_content">
                    <h6>{{ __('system.fields.enter_more_char') }}</h6>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    @include('layouts.right_bar')
</div>
<script src="{{ asset('assets/admin/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/admin/cdns/lazyload.js') }}"></script>
<script src="{{ asset('assets/admin/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/pace-js/pace.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/pristinejs/pristine.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/pages/form-validation.init.js') }}"></script>
<script src="{{ asset('assets/admin/libs/alertifyjs/build/alertify.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/pages/notification.init.js') }}"></script>
<script src="{{ asset('assets/admin/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/pages/form-advanced.init.js') }}"></script>
<script src="{{ asset('assets/admin/libs/imask/imask.min.js') }}"></script>
<script src="{{ asset('assets/admin/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/pages/form-mask.init.js') }}"></script>
<script src="{{ asset('assets/admin/js/custom.js') }}"></script>
@include('js')
@stack('third_party_scripts')
@stack('page_scripts')
</body>
</html>
