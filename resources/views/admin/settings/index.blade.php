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
                            <h4 class="card-title">{{ __('system.environment.application') }}
                                {{ __('system.environment.title') }}
                            </h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.environment.application') }}
                                            {{ __('system.environment.title') }}
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary mb-1">
                                                {{ __('system.environment.application') }}
                                                {{ __('system.environment.title') }}
                                            </div>
                                            <div class="h5 mb-1 font-weight-bold text-gray-800"></div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="{{ url('setting/application') }}">
                                                <i class="fas fa-server fa-2x text-gray-300"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <a class="text-decoration-none" href="bill-verification">Manage</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary mb-1">
                                                {{ __('system.environment.email') }}
                                            </div>
                                            <div class="h5 mb-1 font-weight-bold text-gray-800"></div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="{{ url('setting/email') }}">
                                                <i class="fas fa-server fa-2x text-gray-300"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <a class="text-decoration-none" href="bill-verification">Manage</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary mb-1">
                                                {{ __('system.environment.payment') }}
                                            </div>
                                            <div class="h5 mb-1 font-weight-bold text-gray-800"></div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="{{ url('setting/payment') }}">
                                                <i class="fas fa-server fa-2x text-gray-300"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <a class="text-decoration-none" href="bill-verification">Manage</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary mb-1">
                                                {{ __('system.dashboard.frontend') }}
                                            </div>
                                            <div class="h5 mb-1 font-weight-bold text-gray-800"></div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="{{ route('admin.frontend.admin') }}">
                                                <i class="fas fa-server fa-2x text-gray-300"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <a class="text-decoration-none" href="bill-verification">Manage</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary mb-1">
                                                {{ __('system.environment.recaptcha') }}
                                            </div>
                                            <div class="h5 mb-1 font-weight-bold text-gray-800"></div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="{{ url('setting/recaptcha') }}">
                                                <i class="fas fa-server fa-2x text-gray-300"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <a class="text-decoration-none" href="bill-verification">Manage</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary mb-1">
                                                {{ __('system.environment.seo') }}
                                            </div>
                                            <div class="h5 mb-1 font-weight-bold text-gray-800"></div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="{{ url('setting/seo') }}">
                                                <i class="fas fa-server fa-2x text-gray-300"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <a class="text-decoration-none" href="bill-verification">Manage</a>
                                        </div>
                                    </div>
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
