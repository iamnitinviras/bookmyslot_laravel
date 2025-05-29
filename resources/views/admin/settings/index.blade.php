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
                            <h4 class="card-title mb-0">{{ __('system.environment.menu') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="font-size-16">
                                                {{ __('system.environment.application') }}
                                                {{ __('system.environment.title') }}
                                            </div>
                                            <div class="h5 mb-1 font-weight-bold text-gray-800"></div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="{{ url('setting/application') }}">
                                                <i class="fas fa-server fa-2x"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer py-2 text-end">
                                    <a class="text-decoration-none" href="{{ url('setting/application') }}">
                                        <i class="fas fa-arrow-right font-size-16"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="font-size-16">
                                                {{ __('system.environment.email') }}
                                            </div>
                                            <div class="h5 mb-1 font-weight-bold text-gray-800"></div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="{{ url('setting/email') }}">
                                                <i class="fas fa-envelope fa-2x"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer py-2 text-end">
                                    <a class="text-decoration-none" href="{{ url('setting/email') }}">
                                        <i class="fas fa-arrow-right font-size-16"></i>
                                    </a>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="font-size-16">
                                                {{ __('system.environment.payment') }}
                                            </div>
                                            <div class="h5 mb-1 font-weight-bold text-gray-800"></div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="{{ url('setting/payment') }}">
                                                <i class="fas fa-money-check-alt fa-2x"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer py-2 text-end">
                                    <a class="text-decoration-none" href="{{ url('setting/payment') }}">
                                        <i class="fas fa-arrow-right  font-size-16"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="font-size-16">
                                                {{ __('system.environment.social_settings') }}
                                            </div>
                                            <div class="h5 mb-1 font-weight-bold text-gray-800"></div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="{{ url('setting/social') }}">
                                                <i class="fab fa-google fa-2x"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer py-2 text-end">
                                    <a class="text-decoration-none" href="{{ url('setting/social') }}">
                                        <i class="fas fa-arrow-right  font-size-16"></i>
                                    </a>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="font-size-16">
                                                {{ __('system.dashboard.frontend') }}
                                            </div>
                                            <div class="h5 mb-1 font-weight-bold text-gray-800"></div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="{{ route('admin.environment.frontend') }}">
                                                <i class="fas fa-file-image fa-2x"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer py-2 text-end">
                                    <a class="text-decoration-none" href="{{ route('admin.environment.frontend') }}">
                                        <i class="fas fa-arrow-right font-size-16"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="font-size-16">
                                                {{ __('system.environment.recaptcha') }}
                                            </div>
                                            <div class="h5 mb-1 font-weight-bold text-gray-800"></div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="{{ url('setting/recaptcha') }}">
                                                <i class="fas fa-user-secret fa-2x"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer py-2 text-end">
                                    <a class="text-decoration-none" href="{{ url('setting/recaptcha') }}">
                                        <i class="fas fa-arrow-right font-size-16"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="font-size-16">
                                                {{ __('system.environment.seo') }}
                                            </div>
                                            <div class="h5 mb-1 font-weight-bold text-gray-800"></div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="{{ url('setting/seo') }}">
                                                <i class="fas fa-laptop-code fa-2x"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer py-2 text-end">
                                    <a class="text-decoration-none" href="{{ url('setting/seo') }}">
                                        <i class="fas fa-arrow-right font-size-16"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="font-size-16">
                                                {{ __('system.environment.preferred_settings') }}
                                            </div>
                                            <div class="h5 mb-1 font-weight-bold text-gray-800"></div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="{{ url('setting/preferred') }}">
                                                <i class="fas fa-sun fa-2x"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer py-2 text-end">
                                    <a class="text-decoration-none" href="{{ url('setting/preferred') }}">
                                        <i class="fas fa-arrow-right font-size-16"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->
            </div>
        </div>
    </div>
@endsection
