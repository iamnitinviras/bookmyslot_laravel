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

    <div class="col-xl-3 col-md-6">
        <div class="card card-h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('system.dashboard.total_members') }}</span>
                        <h4 class="mb-3">
                            <span class="counter-value" data-target="{{ $total_members ?? 0 }}">0</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card card-h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('system.dashboard.today_joined_member') }}</span>
                        <h4 class="mb-3">
                            <span class="counter-value" data-target="{{ $today_joined_member ?? 0 }}">0</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('system.members.present_member') }}</span>
                        <h4 class="mb-3">
                            <span class="counter-value" data-target="{{ $present_member ?? 0 }}">0</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('system.members.absent_member') }}</span>
                        <h4 class="mb-3">
                            <span class="counter-value" data-target="{{ $absent_member ?? 0 }}">0</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @include('admin.dashboard.due_payment')
    </div>
    <div class="col-md-6">
        @include('admin.dashboard.follow_up_today')
    </div>
</div>

{{--<div class="row">--}}
{{--    <div class="col-md-6">--}}
{{--        <div class="card">--}}
{{--            <div class="card-header">--}}
{{--                {{trans('system.dashboard.monthly_feedback_chart')}}--}}
{{--            </div>--}}
{{--            <div class="card-body" id="superadmin_monthly_feedback">--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    @if(isset($roadmap_report_list) && count($roadmap_report_list)>0)--}}
{{--        <div class="col-md-6">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    {{trans('system.roadmaps.menu')}}--}}
{{--                </div>--}}
{{--                <div class="card-body" id="roadmap_chart"></div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}
{{--</div>--}}



@push('page_scripts')
    @if((auth()->user()->branch)!= null))
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
