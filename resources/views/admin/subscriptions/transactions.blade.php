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
                            <h4 class="card-title">{{ __('system.plans.transactions') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.plans.transactions') }}</li>
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
                                                    class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('system.payment_setting.manually') }}</span>
                                                <h4>
                                                    <span>{{displayCurrency($manually_total ?? 0)}}</span>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (config('stripe.stripe_status') == 'enable')
                                <div class="col-xl-3 col-md-6">
                                    <div class="card text-success bg-soft-info">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <span
                                                        class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('system.payment_setting.stripe') }}</span>
                                                    <h4>
                                                        <span>{{displayCurrency($stripe_total ?? 0)}}</span>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (config('razorpay.status') == 'enable')
                                <div class="col-xl-3 col-md-6">
                                    <div class="card text-success bg-soft-warning">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <span
                                                        class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('system.payment_setting.razorpay') }}</span>
                                                    <h4>
                                                        <span>{{displayCurrency($razorpay_total ?? 0)}}</span>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              @endif

                            @if (config('paypal.status') == 'enable')
                                <div class="col-xl-3 col-md-6">
                                    <div class="card text-success bg-soft-dark">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <span
                                                        class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('system.payment_setting.paypal') }}</span>
                                                    <h4>
                                                        <span>{{displayCurrency($paypal_total ?? 0)}}</span>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="tab-content">
                                    <div class="tab-pane active">
                                        <div class="row">
                                            <div class="col-sm-12 table-responsive">
                                                <table
                                                    class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer mt-0 table-bordered"
                                                    id="DataTables_Table_0" role="grid"
                                                    aria-describedby="DataTables_Table_0_info">
                                                    <thead>
                                                        <tr role="row">
                                                            <th scope="col">{{__('system.fields.name')}}</th>
                                                            <th scope="col">
                                                                <div class="d-flex justify-content-between">
                                                                    {{__('system.plans.type')}}</div>
                                                            </th>
                                                            <th scope="col">
                                                                <div class="d-flex justify-content-between">
                                                                    {{__('system.plans.payment_method')}}</div>
                                                            </th>
                                                            <th scope="col">
                                                                <div class="d-flex justify-content-between">
                                                                    {{__('system.plans.amount')}}</div>
                                                            </th>
                                                            <th scope="col">
                                                                <div class="d-flex justify-content-between">
                                                                    {{__('system.plans.payment_date')}}</div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(isset($transactions) && count($transactions) > 0)
                                                            @foreach($transactions as $transaction)
                                                                <tr>
                                                                    <td>
                                                                        @if(isset($transaction->user))
                                                                            {{$transaction->user->first_name}} {{$transaction->user->last_name}}
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge bg-info p-1">{{ __('system.plans.' . $transaction->plan->type) }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                                class="badge bg-success p-1">{{ __('system.payment_setting.' . $transaction->payment_method) }}</span>
                                                                        </td>
                                                                    <td>
                                                                        @if(isset($transaction->plan->amount))
                                                                            {{ displayCurrency($transaction->plan->amount) }}
                                                                        @else
                                                                            {{ displayCurrency(0) }}
                                                                        @endif
                                                                    </td>
                                                                    <td>{{($transaction->created_at)}}</td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="9" class="text-center">
                                                                    {{ __('system.crud.data_not_found', ['table' => __('system.plans.subscriptions')]) }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

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
