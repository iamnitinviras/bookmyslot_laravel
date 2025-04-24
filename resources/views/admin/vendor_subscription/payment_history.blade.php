@extends('layouts.app')
@section('title', __('system.payment_setting.payment_history'))
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('system.payment_setting.payment_history') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.payment_setting.payment_history') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div id="products_list" class="dataTables_wrapper dt-bootstrap4 no-footer table_filter">
                            <div id="data-preview" class='overflow-hidden'>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer  table-bordered" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                            <thead>
                                            <tr role="row">
                                                <th scope="col">{{__('system.fields.name')}}</th>
                                                <th scope="col">
                                                    <div class="d-flex justify-content-between">{{__('system.plans.type')}}</div>
                                                </th>
                                                <th scope="col">
                                                    <div class="d-flex justify-content-between">{{__('system.plans.payment_method')}}</div>
                                                </th>
                                                <th scope="col">
                                                    <div class="d-flex justify-content-between">{{__('system.plans.amount')}}</div>
                                                </th>
                                                <th scope="col">
                                                    <div class="d-flex justify-content-between">{{__('system.plans.payment_date')}}</div>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                                @forelse ($transactions as $transaction)
                                                    <tr>
                                                        <td>
                                                            @if($transaction->plan_id==0)
                                                                {{trans('system.plans.trial')}}
                                                            @else
                                                                @if(isset($transaction->plan->local_title)) @endif{{ $transaction->plan->local_title }}
                                                            @endif
                                                        </td>


                                                        <td><span class="badge bg-info p-1">{{ __('system.plans.'.$transaction->plan->type) }}</span></td>
                                                        @if(isset($transaction->subscription) && $transaction->subscription!=null)
                                                            <td><span class="badge bg-success p-1">{{ __('system.payment_setting.'.$transaction->subscription->payment_method) }}</span></td>
                                                        @else
                                                            <td>{{ __('system.payment_setting.offline') }}</td>
                                                        @endif
                                                        <td>
                                                            @if(isset($transaction->plan->amount))
                                                                {{ displayCurrency($transaction->plan->amount) }}
                                                            @else
                                                                {{ displayCurrency(0) }}
                                                            @endif
                                                        </td>
                                                        <td>{{($transaction->created_at)}}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">
                                                            {{ __('system.crud.data_not_found', ['table' => __('system.payment_setting.payment_history')]) }}
                                                        </td>
                                                    </tr>
                                                @endforelse
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
@endsection
