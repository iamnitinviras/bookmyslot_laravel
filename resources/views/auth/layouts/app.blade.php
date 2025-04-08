<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title> @yield('title', 'Welcome') | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{ asset(config('app.favicon_icon')) }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/preloader.min.css') }}" type="text/css" />
    <link href="{{ asset('assets/admin/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    @stack('third_party_stylesheets')
    @stack('page_css')
    <style>
        .auth-bg {
            background-image: url({{asset(config('app.banner_image_two'))}});
            background-attachment: scroll;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body data-topbar="dark">
    <div class="auth-page">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-xxl-4 col-lg-4 col-md-12">
                    <div class="auth-full-page-content d-flex p-sm-5 p-4">
                        <div class="w-100">
                            <div class="d-flex flex-column h-100">

                                <div class="mb-4 mb-md-5 text-center">
                                    <a href="{{ url('/') }}" class="d-block auth-logo">
                                        <img src="{{ asset(config('app.logo')) }}" alt="{{ config('app.name') }}" height="60" class="lazyload">
                                    </a>
                                </div>

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

                                @yield('content')

                                <div class="mt-4 mt-md-5 text-center">
                                    <p class="mb-0">©
                                        <script>
                                            document.write(new Date().getFullYear())
                                        </script> {{ __('auth.copyright') }} | <a href="{{ route('/') }}">{{ config('app.name') }}</a> {{ __('auth.all_rights_reserved') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-8 col-lg-8 d-md-none d-lg-block auth-bg"></div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/admin/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/pace-js/pace.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pages/pass-addon.init.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pages/feather-icon.init.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/pristinejs/pristine.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ asset('assets/admin/js/auth.js') }}"></script>
    @stack('third_party_scripts')
    @stack('page_scripts')
</body>
</html>
