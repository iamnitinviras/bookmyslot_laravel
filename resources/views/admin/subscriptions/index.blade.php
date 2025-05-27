@extends('layouts.app')
@section('title', __('system.plans.subscriptions'))
@push('page_css')
    <style>
        .data-description {
            text-overflow: clip;
            max-height: 50px;
            min-height: 50px;
            overflow: hidden;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('system.plans.subscriptions') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.plans.subscriptions') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card text-success bg-soft-success">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <span
                                                    class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('system.dashboard.total_gyms') }}</span>
                                                <h4>
                                                    <span class="counter-value"
                                                        data-target="{{ $products_count ?? 0 }}">0</span>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xl-3 col-md-6">
                                <div class="card text-success bg-soft-info">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <span
                                                    class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('system.dashboard.total_gyms') }}</span>
                                                <h4>
                                                    <span class="counter-value"
                                                        data-target="{{ $products_count ?? 0 }}">0</span>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xl-3 col-md-6">
                                <div class="card text-success bg-soft-dark">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <span
                                                    class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('system.dashboard.total_gyms') }}</span>
                                                <h4>
                                                    <span class="counter-value"
                                                        data-target="{{ $products_count ?? 0 }}">0</span>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card text-success bg-soft-warning">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <span
                                                    class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('system.dashboard.total_gyms') }}</span>
                                                <h4>
                                                    <span class="counter-value"
                                                        data-target="{{ $products_count ?? 0 }}">0</span>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tab-content">
                                    <div class="tab-pane active">
                                        @include('admin.subscriptions.table')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
