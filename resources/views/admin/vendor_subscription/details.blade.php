@extends('layouts.app')
@section('title', __('system.plans.menu'))
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
                            <h4 class="card-title">{{ __('system.plans.menu') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('admin.vendor.subscription') }}">{{ __('system.plans.menu') }}</a>
                                        </li>
                                        <li class="breadcrumb-item active">{{ $plan->local_title }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <!-- New Design -->
                        <form id="pristine-valid"
                            action="{{ route('admin.vendor.plan.payment', ['plan' => $plan->plan_id]) }}"
                            class="show_spinner payment-form" method="post">
                            @csrf
                            <input type="hidden" name="plan" value="{{ $plan->plan_id }}">
                            <div class="row">

                                <div class="col-xl-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title mb-3">{{ __('system.plans.summary') }}</h4>

                                            <div class="table-responsive">
                                                <table class="table table-bordered mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <td><b>{{ trans('system.plans.pay_plan_title') }}</b>:</td>
                                                            <td>{{ $plan->local_title }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>{{ trans('system.plans.type') }}</b>:</td>
                                                            <td>{{ trans('system.plans.' . $plan->type) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>{{ trans('system.plans.start_date') }}</b>: </td>
                                                            <td>{{ (now()) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>{{ trans('system.plans.expiry_date') }}</b>:</td>
                                                            <td>
                                                                @if ($plan->type == 'onetime')
                                                                    {{ trans('system.plans.lifetime') }}
                                                                @elseif($plan->type == 'weekly')
                                                                    {{ (now()->addWeek()) }}
                                                                @elseif($plan->type == 'monthly')
                                                                    {{ (now()->addMonth()) }}
                                                                @elseif($plan->type == 'yearly')
                                                                    {{ (now()->addYear()) }}
                                                                @elseif($plan->type == 'day')
                                                                    {{ (now()->addDay()) }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th><b>{{ trans('system.plans.total_cost') }}</b>:</th>
                                                            <th>{{ displayCurrency($plan->amount) }}</th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- end table-responsive -->
                                        </div>
                                    </div>
                                    <!-- end card -->
                                </div>
                                <!-- Payment Section -->
                                <div class="col-xl-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div>
                                                <h4 class="card-title">{{ __('system.plans.payment_information') }}</h4>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        @if (config('stripe.stripe_status') == 'enable')
                                                            <div class="form-check form-check-inline font-size-16">
                                                                <input onclick="show_payment_section(this)" required
                                                                    class="form-check-input" type="radio" name="payment_type"
                                                                    id="stripe_payment" value="stripe">
                                                                <label class="form-check-label font-size-13"
                                                                    for="stripe_payment"><i
                                                                        class="fab fa-cc-mastercard me-1 font-size-20 align-top"></i>
                                                                    {{ __('system.payment_setting.credit_and_debit') }}</label>
                                                            </div>
                                                        @endif

                                                        @if (config('paypal.status') == 'enable')
                                                            <div class="form-check form-check-inline font-size-16">
                                                                <input onclick="show_payment_section(this)" required
                                                                    class="form-check-input" type="radio" name="payment_type"
                                                                    id="paypal_payment" value="paypal">
                                                                <label class="form-check-label font-size-13"
                                                                    for="paypal_payment"><i
                                                                        class="fab fa-cc-paypal me-1 font-size-20 align-top"></i>
                                                                    {{ __('system.payment_setting.paypal') }}</label>
                                                            </div>
                                                        @endif

                                                        @if (config('offline.offline_status') == 'enable')
                                                            <div class="form-check form-check-inline font-size-16">
                                                                <input onclick="show_payment_section(this)" required
                                                                    class="form-check-input" type="radio" name="payment_type"
                                                                    id="offline_payment" value="offline">
                                                                <label class="form-check-label font-size-13"
                                                                    for="offline_payment"><i
                                                                        class="far fa-money-bill-alt me-1 font-size-20 align-top"></i>
                                                                    {{ __('system.payment_setting.offline') }}</label>
                                                            </div>
                                                        @endif

                                                        @if (config('razorpay.status') == 'enable')
                                                            <div class="form-check form-check-inline font-size-16">
                                                                <input onclick="show_payment_section(this)" required
                                                                    class="form-check-input" type="radio" name="payment_type"
                                                                    id="razorpay_payment" value="razorpay">
                                                                <label class="form-check-label font-size-13"
                                                                    for="razorpay_payment"><i
                                                                        class="far fa-money-bill-alt me-1 font-size-20 align-top"></i>
                                                                    {{ __('system.payment_setting.razorpay') }}</label>
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div>


                                                <!-- Offline Payment Section -->

                                                @if (isset($offlinePayment->offline_status) && $offlinePayment->offline_status == 'enable')
                                                    <div class="p-4 mt-5 border d-none" id="offline_payment_section">
                                                        <div class="col-md-12">
                                                            <?php    echo nl2br($offlinePayment->instructions); ?>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group mt-4 mb-0">
                                                                <label
                                                                    for="reference">{{ trans('system.payment_setting.reference') }}*</label>
                                                                <input autofocus autocomplete="off" id="reference" type="text"
                                                                    name="reference" class="form-control" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <!-- Stripe Payment-->

                                                @if (isset($stripePayment->stripe_status) && $stripePayment->stripe_status == 'enable')
                                                    <div class="p-4 mt-5 border d-none" id="stripe_payment_section">
                                                        <div id="card-element" class="border-1-gray p-3 border-radius-1">
                                                        </div>
                                                        <div id="card-errors" role="alert"></div>
                                                    </div>
                                                @endif

                                            </div>

                                            <div class="row mt-4">
                                                <div class="col-md-12 text-md-end">
                                                    <button type="submit" id="paynow" class="btn w-100 btn-primary">
                                                        <div class="spinner-border text-primary d-none" role="status">
                                                        </div>
                                                        {{ trans('system.plans.pay_now') }}
                                                    </button>
                                                </div> <!-- end col -->
                                            </div> <!-- end row-->
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page_scripts')
    <script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
@endpush
