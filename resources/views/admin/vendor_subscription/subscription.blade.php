@extends('layouts.app')
@section('title', __('system.plans.subscription'))
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
                            <h4 class="card-title">{{ __('system.plans.your_current_subscription') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item active">
                                            {{ __('system.plans.details_about_your_active_subscription') }}
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="row">
                            @if((isset($subscription) && $subscription != null))
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">{{ __('system.plans.summary') }}</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table mb-0 table-bordered">
                                                    <tbody>
                                                        @if(isset($subscription->plan_id) && $subscription->plan_id == 0)
                                                            <tr>
                                                                <td><b>{{ trans('system.plans.pay_plan_title') }}</b>:</td>
                                                                <td><span
                                                                        class="badge bg-success p-1">{{ trans('system.plans.trial') }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>{{ trans('system.plans.expiry_date') }}</b>:</td>
                                                                <td>{{ formatDate($subscription->expiry_date) }}</td>
                                                            </tr>
                                                        @else
                                                            @if(isset($subscription))
                                                                <tr>
                                                                    <td><b>{{ trans('system.plans.pay_plan_title') }}</b>:</td>
                                                                    <td>{{ $subscription->plan->local_title }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><b>{{ trans('system.plans.type') }}</b>:</td>
                                                                    <td><span
                                                                            class="badge bg-primary">{{ trans('system.plans.' . $subscription->type) }}</span>
                                                                    </td>
                                                                </tr>

                                                                @if (isset($subscription->start_date))
                                                                    <tr>
                                                                        <td><b>{{ trans('system.plans.start_date') }}</b>: </td>
                                                                        <td>{{ formatDate($subscription->start_date) }}</td>
                                                                    </tr>
                                                                @endif

                                                                @if (isset($subscription->expiry_date))
                                                                    <tr>
                                                                        <td><b>{{ trans('system.plans.expiry_date') }}</b>: </td>
                                                                        <td>{{ formatDate($subscription->expiry_date) }}</td>
                                                                    </tr>
                                                                @endif

                                                                <tr>
                                                                    <th><b>{{ trans('system.plans.total_cost') }}</b>:</th>
                                                                    <th>{{ displayCurrency($subscription->amount) }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <th><b>{{ trans('system.plans.payment_method') }}</b>:</th>
                                                                    <th><span
                                                                            class="badge bg-info">{{ trans('system.payment_setting.' . $subscription->payment_method) }}</span>
                                                                    </th>
                                                                </tr>
                                                                @if (isset($subscription->status) && $subscription->status == 'canceled')
                                                                    <tr>
                                                                        <td><b>{{ trans('system.payment_setting.status') }}</b>: </td>
                                                                        <td><span
                                                                                class="badge bg-danger">{{ trans('system.plans.canceled') }}</span>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endif
                                                        @endif

                                                        <tr>
                                                            <td><b>{{ trans('system.plans.branch_limit') }}</b>:</td>
                                                            <td>
                                                                @if ($subscription->branch_unlimited == 'yes')
                                                                    {{ trans('system.plans.branch_unlimited') }}
                                                                @else
                                                                    {{ $subscription->branch_limit }}
                                                                @endif
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td><b>{{ trans('system.plans.staff_limit') }}</b>:</td>
                                                            <td>
                                                                @if ($subscription->staff_unlimited == 'yes')
                                                                    {{ trans('system.plans.unlimited_staff') }}
                                                                @else
                                                                    {{ $subscription->staff_limit }}
                                                                @endif
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- end table-responsive -->
                                        </div>
                                        @if (isset($subscription->subscription_id) && $subscription->subscription_id != null)
                                            <div class="card-footer bg-transparent border-top text-muted">
                                                <div class="d-flex flex-wrap gap-2">
                                                    <form
                                                        action="{{ route('admin.vendor.subscription.cancel', ['subscription' => $subscription->id]) }}"
                                                        method="POST" autocomplete="off" class="data-confirm"
                                                        data-confirm-message="{{ __('system.plans.cancel_subscription_title') }}"
                                                        data-confirm-title="{{ __('system.plans.cancel_subscription') }}"
                                                        id="cancel-form_{{ $subscription->id }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger">
                                                            {{ trans('system.plans.cancel_subscription') }}
                                                        </button>
                                                        {!! html()->closeModelForm() !!}

                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">{{ __('system.plans.available_plans') }}</h4>
                                    </div><!-- end card header -->

                                    <div class="card-body">

                                        @if (isset($plans) && count($plans) > 0)
                                            <div class="row">
                                                @foreach ($plans as $plan)
                                                    <div class="col-md-4">
                                                        <div class="card mb-xl-0">
                                                            <div class="card-body">
                                                                <div class="p-2">

                                                                    @if (isset($subscription->plan_id) && $subscription->plan_id == $plan->plan_id)
                                                                        <div class="pricing-badge">
                                                                            <span class="badge"> <i
                                                                                    data-feather="check-circle"></i></span>
                                                                        </div>
                                                                    @endif

                                                                    <h5 class="font-size-16">{{ $plan->local_title }}</h5>
                                                                    <h1 class="mt-3">{{ displayCurrency($plan->amount) }} <span
                                                                            class="text-muted font-size-16 fw-medium">/
                                                                            {{ trans('system.plans.' . $plan->type) }}</span></h1>
                                                                    <div class="mt-4 pt-2 text-muted">

                                                                        @if ($plan->branch_unlimited == 'yes')
                                                                            <p class="mb-3 font-size-15"><i
                                                                                    class="mdi mdi-check-circle text-secondary font-size-18 me-2"></i>{{ trans('system.plans.branch_unlimited') }}
                                                                            </p>
                                                                        @else
                                                                            <p class="mb-3 font-size-15"><i
                                                                                    class="mdi mdi-check-circle text-secondary font-size-18 me-2"></i><strong>{{ $plan->branch_limit }}</strong>
                                                                                {{ trans('system.plans.branch_limit') }}</p>
                                                                        @endif

                                                                        @if ($plan->staff_unlimited == 'yes')
                                                                            <p class="mb-3 font-size-15"><i
                                                                                    class="mdi mdi-check-circle text-secondary font-size-18 me-2"></i>{{ trans('system.plans.unlimited_staff') }}
                                                                            </p>
                                                                        @else
                                                                            <p class="mb-3 font-size-15"><i
                                                                                    class="mdi mdi-check-circle text-secondary font-size-18 me-2"></i><strong>{{ $plan->staff_limit }}</strong>
                                                                                {{ trans('system.plans.staff_limit') }}</p>
                                                                        @endif

                                                                        <p class="mb-3 font-size-15"><i
                                                                                class="mdi mdi-check-circle text-secondary font-size-18 me-2"></i>{{ trans('system.plans.unlimited_support') }}
                                                                        </p>
                                                                    </div>

                                                                    @if ((isset($subscription->plan_id) && $subscription->plan_id != $plan->plan_id) || $subscription == null)
                                                                        <div class="mt-4 pt-2">
                                                                            <a href="{{ url('subscription/plan/' . $plan->plan_id) }}"
                                                                                class="btn btn-outline-primary w-100">{{ __('system.plans.select_plan') }}</a>
                                                                        </div>
                                                                    @else

                                                                        <div class="mt-4 pt-2">
                                                                            <a href="{{ url('subscription/plan/' . $plan->plan_id) }}"
                                                                                class="btn btn-primary w-100">{{ __('system.plans.current_plan') }}</a>
                                                                        </div>
                                                                    @endif

                                                                </div>
                                                            </div>
                                                            <!-- end card body -->
                                                        </div>
                                                        <!-- end card -->
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            {{ __('system.crud.data_not_found', ['table' => __('system.plans.menu')]) }}
                                        @endif
                                    </div><!-- end card-body -->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
