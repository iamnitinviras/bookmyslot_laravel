@extends('layouts.app')
@section('title', __('system.environment.menu'))
@section('content')
    @php($vendor_setting='active')
    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('system.environment.display') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a>
                                        </li>
                                        <li class="breadcrumb-item active">{{ __('system.environment.display') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('admin.vendors_setting.nav')
                </div>
                <div class="card-footer bg-transparent border-top text-muted">
                    <div class="row">
                        <div class="col-12 mt-1">
                            <button class="btn btn-primary" type="submit">{{ __('system.crud.save') }}</button>
                        </div>
                    </div>
                </div>
                <!-- end card -->
            </div>
        </div>
    </div>
@endsection
