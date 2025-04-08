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
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.plans.menu') }}</li>
                                    </ol>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6 col-xl-6 text-end add-new-btn-parent">
                            <a href="{{ route('admin.plans.create') }}" class="btn btn-primary btn-rounded waves-effect waves-light"><i class="bx bx-plus me-1"></i>{{ __('system.crud.add_new') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">


                        <div class="col-md-12">
                            <div class="mb-4">
                                <div id="products_list" class="dataTables_wrapper dt-bootstrap4 no-footer table_filter">
                                    <div class='overflow-hidden'>
                                        @include('admin.plans.table')
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-5">
                            <div class="card">
                                <div class="card-header">
                                    {{ trans('system.plans.trial') }}
                                </div>
                                <div class="card-body">
                                    <form autocomplete="off" novalidate="" action="{{ route('admin.trailDetails.store') }}" id="pristine-valid" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-3 mb-2">
                                                <div class="form-group">
                                                    <label class="text-label">{{ trans('system.plans.trial_days') }}</label>
                                                    <input min="1" max="60" value="{{ old('trial_days') ? old('trial_days') : (isset($trial_days) ? $trial_days : '') }}" type="number"  name="trial_days" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 mb-2">
                                                <div class="form-group">
                                                    <label class="text-label">{{ trans('system.plans.branch_limit') }}*</label>
                                                    <input min="1" value="{{ old('branch_limit') ?? ($trial_branch ?? 0) }}" type="number" name="branch_limit" id="branch_limit" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 mb-2">
                                                <div class="form-group">
                                                    <label class="text-label">{{ trans('system.plans.member_limit') }}*</label>
                                                    <input min="1" value="{{ old('member_limit') ?? ($trial_member ?? 0) }}" type="number" name="member_limit" id="member_limit" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 mb-2">
                                                <div class="form-group">
                                                    <label class="text-label">{{ trans('system.plans.staff_limit') }}*</label>
                                                    <input min="1" value="{{ old('staff_limit') ?? ($trial_staff ?? 0) }}" type="number" name="staff_limit" id="staff_limit" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mt-4 mb-2">
                                                <button class="btn btn-primary" type="submit">{{ __('system.crud.save') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
@endsection
