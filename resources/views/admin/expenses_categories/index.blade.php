@extends('layouts.app')
@section('title', __('system.expenses_categories.menu'))
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('system.expenses_categories.menu') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('admin.expenses.index') }}">{{ __('system.expenses.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.expenses_categories.menu') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        @can('add expenses_categories')
                            <div class="col-md-6 col-xl-6 text-end add-new-btn-parent">
                                <a href="{{ route('admin.expense-categories.create') }}" class="btn btn-primary btn-rounded waves-effect waves-light"><i class="bx bx-plus me-1"></i>{{ __('system.crud.add_new') }}</a>
                            </div>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div id="products_list" class="dataTables_wrapper dt-bootstrap4 no-footer table_filter">
                            <div id="data-preview" class='overflow-hidden'>
                                @include('admin.expenses_categories.table')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
