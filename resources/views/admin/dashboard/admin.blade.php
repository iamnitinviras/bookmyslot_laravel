<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{ __('system.dashboard.menu') }}</h4>
        </div>
    </div>
</div>
<div class="row">
    @hasanyrole('vendor')
    {{-- vendor missing details on boarding --}}
    @php
        $show_vendor_boarding = false;
        if ((isset($branches_count) && $branches_count == 0) || empty(auth()->user()->email_verified_at) || empty(auth()->user()->address) || empty(auth()->user()->city) || empty(auth()->user()->zip) || empty(auth()->user()->country)) {
            $show_vendor_boarding = true;
        }
    @endphp
    @if ($show_vendor_boarding)
        <div class="col-md-12">
            <div class="card card-h-100">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('system.fields.setting_reconfigure') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if ($branches_count == 0)
                            <div class="col-md-6 mb-3">
                                <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mb-0" role="alert">
                                    <a href="{{ route('admin.branch.create') }}">
                                        <i class="mdi mdi-google-my-board label-icon"></i>
                                        {{ __('system.fields.atleast_one', ['name' => __('system.branch.title')]) }}
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if (empty(auth()->user()->address) ||
                                empty(auth()->user()->city) ||
                                empty(auth()->user()->zip) ||
                                empty(auth()->user()->country))
                            <div class="col-md-6 mb-3">
                                <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mb-0" role="alert">
                                    <a href="{{ route('admin.profile.edit') }}">
                                        <i class="mdi mdi-account-edit-outline label-icon"></i>
                                        {{ __('system.dashboard.missing_address') }}
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
    @endhasanyrole

    @hasanyrole('Super-Admin')
    {{-- vendor missing details on boarding --}}
    @php

        $show_admin_boarding = false;
        $show_smtp = false;
        $show_system = false;
        if (empty(config('mail.from.address')) || empty(config('mail.mailers.smtp.host')) || empty(config('mail.mailers.smtp.port')) || empty(config('mail.mailers.smtp.encryption')) || empty(config('mail.mailers.smtp.username')) || empty(config('mail.mailers.smtp.password'))) {
            $show_admin_boarding = true;
            $show_smtp = true;
        }

        if (empty(config('custom.timezone')) || empty(config('custom.date_time_format')) || empty(config('custom.date_format')) || empty(config('custom.currency')) || empty(config('custom.currency_symbol')) || (empty(config('custom.favicon_icon')) || config('custom.favicon_icon') == '/assets/images/defualt_logo/logo.png') || (empty(config('custom.logo')) || config('custom.logo') == '/assets/images/defualt_logo/logo.png')) {
            $show_admin_boarding = true;
            $show_system = true;
        }

        if (!extension_loaded('imagick')){
            $show_admin_boarding = true;
        }

        if (isset($payment_setting_count) && $payment_setting_count == 0) {
            $show_admin_boarding = true;
        }
    @endphp
    @if ($show_admin_boarding)
        <div class="col-md-12">
            <div class="card card-h-100">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('system.fields.setting_reconfigure') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">

                        @if (!extension_loaded('imagick'))
                            <div class="col-md-6 mb-3">
                                <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mb-0" role="alert">
                                    <a href="https://github.com/Imagick/imagick" target="_blank">
                                        <i class="mdi mdi-qrcode-scan label-icon"></i>
                                        {{ __('system.fields.imagick_install') }} Imagick PHP Extension
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if ($show_smtp)
                            <div class="col-md-6 mb-3">
                                <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mb-0" role="alert">
                                    <a href="{{ route('admin.environment.setting.email') }}">
                                        <i class="mdi mdi-email label-icon"></i>
                                        {{ __('system.dashboard.missing_smpt') }}
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if (isset($payment_setting_count) && $payment_setting_count == 0)
                            <div class="col-md-6 mb-3">
                                <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mb-0" role="alert">
                                    <a href="{{ route('admin.environment.payment') }}">
                                        <i class="mdi mdi-credit-card label-icon"></i>
                                        {{ __('system.dashboard.missing_payment_details') }}
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if ($show_system)
                            <div class="col-md-6 mb-3">
                                <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mb-0" role="alert">
                                    <a href="{{ route('admin.environment.setting') }}">
                                        <i class="mdi mdi-alert-circle-outline label-icon"></i>
                                        {{ __('system.dashboard.missing_system_details') }}
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
    @endhasanyrole

    @hasanyrole('staff|vendor')
    @can('show categories')
        <div class="col-xl-3 col-md-6">
            <div class="card card-h-100">
                <div class="card-body">
                    <a href="{{ route('admin.packages.index') }}">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                        <span
                                            class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('system.dashboard.total_categories') }}</span>
                                <h4 class="mb-3">
                                    <span class="counter-value" data-target="{{ $categories_count ?? 0 }}">0</span>
                                </h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    @endcan
    @endhasanyrole

    @hasanyrole('Super-Admin')
    <div class="col-xl-3 col-md-6">
        <div class="card card-h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('system.dashboard.total_products') }}</span>
                        <h4 class="mb-3">
                            <span class="counter-value" data-target="{{ $products_count ?? 0 }}">0</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-h-100">
            <div class="card-body">
                <a href="{{ route('admin.vendors.index') }}">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('system.dashboard.total_vendors') }}</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $vendors_count ?? 0 }}">0</span>
                            </h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-h-100">
            <div class="card-body">
                <a href="{{ route('admin.subscriptions') }}">
                    <div class="d-flex align-items-center">

                        <div class="flex-grow-1">
                                    <span
                                        class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('system.dashboard.pending_subscriptions') }}</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $pending_subscriptions ?? 0 }}">0</span>
                            </h4>
                        </div>

                    </div>
                </a>
            </div>
        </div>
    </div>
    @endhasanyrole

    @can('show staff')
        <div class="col-xl-3 col-md-6">
            <div class="card card-h-100">
                <div class="card-body">
                    @hasanyrole('Super-Admin')
                    <a href="javascript:void(0)">
                        @else
                            <a href="{{ route('admin.staffs.index') }}">
                                @endhasanyrole

                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                            <span
                                class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('system.dashboard.total_users') }}</span>
                                        <h4 class="mb-3">
                                            <span class="counter-value" data-target="{{ $users_count ?? 0 }}">0</span>
                                        </h4>
                                    </div>
                                </div>
                            </a>
                </div>
            </div>
        </div>
    @endcan
</div>

@if((auth()->user()->product!= null) && auth()->user()->product->allow_feature_request==true)
    @hasanyrole('staff|vendor')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    {{trans('system.dashboard.monthly_feedback_chart')}}
                </div>
                <div class="card-body" id="superadmin_monthly_feedback">

                </div>
            </div>
        </div>
        @if(isset($roadmap_report_list) && count($roadmap_report_list)>0)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        {{trans('system.roadmaps.menu')}}
                    </div>
                    <div class="card-body" id="roadmap_chart"></div>
                </div>
            </div>
        @endif
    </div>
    @endhasanyrole
@endif
@push('page_scripts')
    @if((auth()->user()->product!= null) && auth()->user()->product->allow_feature_request==true)
        <script src="https://code.highcharts.com/highcharts.js"></script>
        @if(isset($monthlyCounts) && count($monthlyCounts)>0)
            <script type="text/javascript">
                let mothly_feedback_list =<?php echo json_encode($monthlyCounts); ?>;
                Highcharts.chart('superadmin_monthly_feedback', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        align: 'left',
                        text: ''
                    },
                    accessibility: {
                        announceNewData: {
                            enabled: true
                        }
                    },
                    xAxis: {
                        type: 'category'
                    },
                    yAxis: {
                        title: {
                            text: '{{trans('system.feature_requests.title')}}'
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    series: [{
                        name: '{{trans('system.feature_requests.title')}}',
                        colorByPoint: true,
                        data: mothly_feedback_list
                    }],
                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    }
                });
            </script>
        @endif

        @if(isset($roadmap_report_list) && count($roadmap_report_list)>0)
            <script>
                let roadmap_report_list =<?php echo json_encode($roadmap_report_list); ?>;

                Highcharts.chart('roadmap_chart', {
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        align: 'left',
                        text: ''
                    },
                    accessibility: {
                        announceNewData: {
                            enabled: true
                        }
                    },
                    xAxis: {
                        type: 'category'
                    },
                    yAxis: {
                        title: {
                            text: '{{trans('system.feature_requests.title')}}'
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    series: [{
                        name: '{{trans('system.roadmaps.title')}}',
                        colorByPoint: true,
                        data: roadmap_report_list
                    }],
                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    }
                });
            </script>
        @endif
    @endif
@endpush
