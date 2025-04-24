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
        <div class="col-md-12">
            @if((isset($subscription) && $subscription != null))
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('system.plans.your_current_subscription') }}</h4>
                        <p class="mb-0">{{ __('system.plans.details_about_your_active_subscription') }}</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if(isset($subscription->plan_id) && $subscription->plan_id == 0)
                                <div class="col-md-4 py-2">
                                    <b>{{ trans('system.plans.pay_plan_title') }}</b>: <span
                                        class="badge bg-success p-1">{{ trans('system.plans.trial') }}
                                </div>
                                <div class="col-md-4 py-2">
                                    <b>{{ trans('system.plans.expiry_date') }}</b>:
                                    {{ formatDate($subscription->expiry_date) }}
                                </div>
                            @else
                                <div class="col-md-4 py-2">
                                    <b>{{ trans('system.plans.pay_plan_title') }}</b>:
                                    {{ $subscription->plan->local_title }}
                                </div>
                                <div class="col-md-4 py-2">
                                    <b>{{ trans('system.plans.type') }}</b>: <span
                                        class="badge bg-primary">{{ trans('system.plans.' . $subscription->type) }}</span>
                                </div>
                                <div class="col-md-4 py-2">
                                    @if (isset($subscription->start_date))
                                        <b>{{ trans('system.plans.start_date') }}</b>:
                                        {{ formatDate($subscription->start_date) }}
                                    @endif
                                </div>
                                @if (isset($subscription->expiry_date))
                                    <div class="col-md-4 py-2">
                                        <b>{{ trans('system.plans.expiry_date') }}</b>:
                                        {{ formatDate($subscription->expiry_date) }}
                                    </div>
                                @endif

                                <div class="col-md-4 py-2"><b>{{ trans('system.plans.payment_method') }}</b>: <span
                                        class="badge bg-info">{{ trans('system.payment_setting.' . $subscription->payment_method) }}</span>
                                </div>

                                @if (isset($subscription->status) && $subscription->status == 'canceled')
                                    <div class="col-md-4 py-2">
                                        <b>{{ trans('system.payment_setting.status') }}</b>:
                                        <span class="badge bg-danger">{{ trans('system.plans.canceled') }}</span>
                                    </div>
                                @endif

                                <div class="col-md-4 py-2">
                                    <b>{{ trans('system.plans.branch_limit') }}</b>:
                                    @if ($subscription->branch_unlimited == 'yes')
                                        {{ trans('system.plans.branch_unlimited') }}
                                    @else
                                        {{ $subscription->branch_limit }}
                                    @endif
                                </div>

                                <div class="col-md-4 py-2">
                                    <b>{{ trans('system.plans.staff_limit') }}</b>:
                                    @if ($subscription->staff_unlimited == 'yes')
                                        {{ trans('system.plans.unlimited_staff') }}
                                    @else
                                        {{ $subscription->staff_limit }}
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                    @if (isset($subscription->subscription_id) && $subscription->subscription_id != null)
                        <div class="card-footer">
                            <form action="{{ route('admin.vendor.subscription.cancel', ['subscription' => $subscription->id]) }}"
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
                    @endif
                </div>
            @endif
        </div>
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
                                                        <span class="badge"> <i data-feather="check-circle"></i></span>
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
@endsection
