@extends('layouts.app')
@section('title', __('system.plans.subscription'))
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('system.vendors.menu') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('home') }}">
                                                {{ __('system.dashboard.menu') }}
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('admin.vendors.index') }}">
                                                {{ __('system.vendors.menu') }}
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a
                                                href="{{ route('admin.vendors.show', $vendor->id) }}">{{ $vendor->first_name . ' ' . $vendor->last_name }}</a>
                                        </li>
                                        <li class="breadcrumb-item active">
                                            {{ __('system.plans.change_plan') }}
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-6 text-end">
                            <a href="{{ route('admin.vendors.show', $vendor->id) }}"
                                class="btn text-muted d-none d-sm-inline-block btn-link">
                                <i class="mdi mdi-arrow-left me-1"></i>
                                {{ __('system.crud.back') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        @if (config('razorpay.status') == 'enable' || config('paypal.status') == 'enable')
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-warning" role="alert">
                                        <h5 class="alert-heading">{{ __('system.plans.plan_switch_requires_user_approval') }}
                                        </h5>
                                        <hr />
                                        <p class="mb-1">
                                            {{ __('system.plans.plan_switch_info_one') }}
                                        </p>
                                        <p>
                                            {{ __('system.plans.plan_switch_info_two') }}
                                        </p>
                                    </div>

                                </div>
                            </div>
                        @endif
                        <div class="row">
                            @if((isset($subscription) && $subscription != null))
                                <div class="col-md-6">
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
                                                                @if ($subscription->unlimited_branch == 'yes')
                                                                    {{ trans('system.plans.unlimited_branch') }}
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
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">{{ __('system.plans.change_plan') }}</h4>
                                    </div><!-- end card header -->

                                    <div class="card-body">
                                        @if (isset($plans) && count($plans) > 0)
                                            <div class="accordion" id="accordionExample">
                                                @foreach ($plans as $key => $plan)
                                                                                {!! html()->form('post', route('admin.vendors.updatePlan.submit', ['vendor' => $vendor->id]))
                                                    ->class('data-confirm')
                                                    ->attribute('autocomplete', 'off')
                                                    ->attribute('data-confirm-message', __('system.fields.confirm_vendor_change_plan'))
                                                    ->attribute('data-confirm-title', __('system.plans.change_plan'))
                                                    ->id('change_plan-form_' . $vendor->id)->open() !!}
                                                                                <div class="accordion-item">
                                                                                    <h2 class="accordion-header" id="headingOne{{ $plan->plan_id }}">
                                                                                        <button class="accordion-button fw-medium" type="button"
                                                                                            data-bs-toggle="collapse"
                                                                                            data-bs-target="#collapseOne{{ $plan->plan_id }}"
                                                                                            aria-expanded="true"
                                                                                            aria-controls="collapseOne{{ $plan->plan_id }}">
                                                                                            <div class="row w-100">
                                                                                                <div class="col-md-6">
                                                                                                    @if (isset($subscription->plan_id) && $subscription->plan_id == $plan->plan_id)
                                                                                                        <i class="fa fa-check-circle"></i>
                                                                                                    @endif
                                                                                                    {{ $plan->local_title }}
                                                                                                </div>
                                                                                                <div class="col-md-6" style="text-align: right">
                                                                                                    {{ displayCurrency($plan->amount) }} /
                                                                                                    {{ ucfirst($plan->type) }}</span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </button>
                                                                                    </h2>
                                                                                    <div id="collapseOne{{ $plan->plan_id }}"
                                                                                        class="accordion-collapse collapse @if (isset($subscription->plan_id) && $subscription->plan_id == $plan->plan_id) show @endif"
                                                                                        aria-labelledby="headingOne{{ $plan->plan_id }}"
                                                                                        data-bs-parent="#accordionExample{{ $plan->plan_id }}">
                                                                                        <div class="accordion-body">
                                                                                            <div class="text-muted">

                                                                                                @if ($plan->unlimited_branch == 'yes')
                                                                                                    <p class="mb-3 font-size-15"><i
                                                                                                            class="mdi mdi-check-circle text-secondary font-size-18 me-2"></i>{{ trans('system.plans.unlimited_branch') }}
                                                                                                    </p>
                                                                                                @else
                                                                                                    <p class="mb-3 font-size-15"><i
                                                                                                            class="mdi mdi-check-circle text-secondary font-size-18 me-2"></i><strong>{{ $plan->branch_limit }}</strong>
                                                                                                        {{ trans('system.plans.branch_limit') }}
                                                                                                    </p>
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
                                                                                            <input type="hidden" name="plan_id" value="{{ $plan->plan_id }}">
                                                                                            @if($subscription == null)
                                                                                                <div class="mt-4 pt-2">
                                                                                                    <button type="submit" class="btn btn-success w-100"><i
                                                                                                            class="fa fa-check-circle"></i>
                                                                                                        {{ __('system.plans.choose_plan') }}</button>
                                                                                                </div>
                                                                                            @else
                                                                                                @if (isset($subscription->plan_id) && $subscription->plan_id != $plan->plan_id)
                                                                                                    <div class="mt-4 pt-2">
                                                                                                        <button type="submit" class="btn btn-success w-100"><i
                                                                                                                class="fa fa-check-circle"></i>
                                                                                                            {{ __('system.plans.choose_plan') }}</button>
                                                                                                    </div>
                                                                                                @endif
                                                                                            @endif

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                {!! html()->closeModelForm() !!}
                                                @endforeach
                                            </div><!-- end accordion -->
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
