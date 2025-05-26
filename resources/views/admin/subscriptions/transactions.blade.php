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
                                                        <tr>
                                                            <th>{{trans('system.fields.name')}}</th>
                                                            <th>{{trans('system.plans.plan_name')}}</th>
                                                            <th>{{trans('system.plans.payment_method')}}</th>
                                                            <th>{{trans('system.plans.start_date')}}</th>
                                                            <th>{{trans('system.plans.expiry_date')}}</th>
                                                            <th>{{trans('system.plans.details')}}</th>
                                                            <th>{{trans('system.plans.status')}}</th>
                                                            <th>{{trans('system.dashboard.action')}}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(isset($transactions) && count($transactions) > 0)
                                                            @foreach($transactions as $transaction)
                                                                <tr data-url="{{ url('get-rightbar-content') }}"
                                                                    data-id="{{ $transaction->id }}"
                                                                    data-action="subscription-history"
                                                                    @if(request()->action == 'approved') class="app-cursor-pointer"
                                                                    onclick="show_rightbar_section(this)" @endif>
                                                                    <td> @if(isset($transaction->user))
                                                                    {{$transaction->user->first_name}} @endif</td>
                                                                    <td> @if(isset($transaction->plan->title))
                                                                    {{$transaction->plan->local_title}} @else
                                                                        {{ __('system.plans.trial') }} @endif
                                                                    </td>

                                                                    <td>{{ trans('system.payment_setting.' . $transaction->payment_method) }}
                                                                    </td>

                                                                    <td>{{formatDate($transaction->start_date)}}</td>

                                                                    @if(isset($transaction->expiry_date) && $transaction->expiry_date != null)
                                                                        <td>{{formatDate($transaction->expiry_date)}}</td>
                                                                    @else
                                                                        <td data-action="{{$transaction->expiry_date}}">
                                                                            {{ trans('system.plans.lifetime') }}</td>
                                                                    @endif
                                                                    <td style="width: 300px">
                                                                        {{$transaction->details}}
                                                                    </td>
                                                                    <td>
                                                                        @if($transaction->status == 'approved')
                                                                            <span
                                                                                class="badge bg-success font-size-12">{{trans('system.plans.approved')}}</span>
                                                                        @elseif($transaction->status == 'rejected')
                                                                            <span
                                                                                class="badge bg-danger font-size-12">{{trans('system.plans.rejected')}}</span>
                                                                        @elseif($transaction->status == 'pending')
                                                                            <span
                                                                                class="badge bg-secondary font-size-12">{{trans('system.plans.pending')}}</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if($transaction->status != 'approved')

                                                                            <div class="dropdown">
                                                                                <a href="#" class="dropdown-toggle card-drop"
                                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                                    <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                                                </a>
                                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                                    @if($transaction->status == 'pending')
                                                                                        <li>
                                                                                            <form
                                                                                                action="{{ route('admin.subscriptions.approve', ['subscription' => $transaction->id]) }}"
                                                                                                method="POST" autocomplete="off"
                                                                                                class="data-confirm"
                                                                                                data-confirm-message="{{ __('system.fields.are_you_sure', ['name' => __('system.plans.approve')]) }}"
                                                                                                data-confirm-title="{{ __('system.plans.approve') }}"
                                                                                                id="approve_form_{{ $transaction->id }}">
                                                                                                @csrf
                                                                                                @method('PUT')
                                                                                                <button type="submit"
                                                                                                    class="dropdown-item btn btn-success"><i
                                                                                                        class="mdi mdi-check-all font-size-16 text-success me-1"></i>
                                                                                                    {{trans('system.plans.approve')}}</button>
                                                                                                {!! html()->closeModelForm() !!}
                                                                                        </li>

                                                                                        <li>
                                                                                            <form
                                                                                                action="{{ route('admin.subscriptions.reject', ['subscription' => $transaction->id]) }}"
                                                                                                method="POST" autocomplete="off"
                                                                                                class="data-confirm"
                                                                                                data-confirm-message="{{ __('system.fields.are_you_sure', ['name' => __('system.plans.reject')]) }}"
                                                                                                data-confirm-title="{{ __('system.plans.reject') }}"
                                                                                                id="reject_form_{{ $transaction->id }}">
                                                                                                @csrf
                                                                                                @method('PUT')
                                                                                                <button type="submit"
                                                                                                    class="dropdown-item btn btn-danger"><i
                                                                                                        class="mdi mdi-trash-can font-size-16 text-danger me-1"></i>
                                                                                                    {{trans('system.plans.reject')}}</button>
                                                                                                {!! html()->closeModelForm() !!}
                                                                                        </li>
                                                                                    @elseif($transaction->status == 'rejected')
                                                                                        <li>
                                                                                            <form
                                                                                                action="{{ route('admin.subscriptions.delete', ['subscription' => $transaction->id]) }}"
                                                                                                method="POST" autocomplete="off"
                                                                                                class="data-confirm"
                                                                                                data-confirm-message="{{ __('system.plans.subscription_delete', ['name' => __('system.crud.delete')]) }}"
                                                                                                data-confirm-title="{{ __('system.crud.delete') }}"
                                                                                                id="delete_form_{{ $transaction->id }}">
                                                                                                @csrf
                                                                                                @method('PUT')
                                                                                                <button type="submit"
                                                                                                    class="dropdown-item btn btn-danger"><i
                                                                                                        class="mdi mdi-trash-can font-size-16 text-danger me-1"></i>
                                                                                                    {{trans('system.crud.delete')}}</button>
                                                                                                {!! html()->closeModelForm() !!}
                                                                                        </li>
                                                                                    @endif
                                                                                </ul>
                                                                            </div>

                                                                        @endif

                                                                    </td>
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
