@extends('layouts.app')
@section('title', __('system.fields.pending_payment'))
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ trans('system.fields.pending_payment') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{trans('system.fields.pending_payment') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-6 text-end add-new-btn-parent">
                            <a href="{{ route('admin.members.create') }}" class="btn btn-outline-primary btn-rounded">
                                <i class="bx bx-arrow-back me-1"></i>
                                {{ __('system.crud.back') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div id="users_list" class="dataTables_wrapper dt-bootstrap4 no-footer table_filter">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer  table-bordered" id="DataTables_Table_0" role="grid"
                                           aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                        <tr role="row">
                                            <th scope="col">
                                                <div class="d-flex justify-content-between w-60px">
                                                    @sortablelink('gym_customer_id', __('system.members.id'), [], ['class' => 'w-100 text-gray'])
                                                </div>
                                            </th>
                                            <th scope="col">
                                                <div class="d-flex justify-content-between w-150px">
                                                    @sortablelink('name', __('system.fields.name'), [], ['class' => 'w-100 text-gray'])
                                                </div>
                                            </th>

                                            <th scope="col">
                                                <div class="d-flex justify-content-between w-100px">
                                                    @sortablelink('phone_number', __('system.fields.phone_number'), [], ['class' => 'w-100 text-gray'])
                                                </div>
                                            </th>
                                            <th scope="col">
                                                <div class="d-flex justify-content-between w-80px">
                                                    @sortablelink('join_date', __('system.members.join_date'), [], ['class' => 'w-100 text-gray'])
                                                </div>
                                            </th>
                                            <th scope="col">
                                                <div class="d-flex justify-content-between w-100px">
                                                    @sortablelink('package_end_date', __('system.members.package_end_date'), [], ['class' => 'w-100 text-gray'])
                                                </div>
                                            </th>
                                            <th class="h-mw-80px">{{ __('system.fields.created_by') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($pending_payments as $ppayment)
                                                <tr>
                                                    <td>{{ $ppayment->member->gym_customer_id }}</td>
                                                    <td>
                                                        {{ $ppayment->member->name}}
                                                    </td>
                                                    <td>{{ $ppayment->member->phone_number }}</td>
                                                    <td>{{ $ppayment->member->join_date }}</td>
                                                    <td>{{ $ppayment->member->package_end_date }}</td>
                                                    <td>
                                                        <a role="button" href="{{ route('admin.collect.payment', ['payment'=>$ppayment->id]) }}" class="btn btn-primary">{{trans('system.fields.collect_payment')}}</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">
                                                        {{ __('system.crud.data_not_found', ['table' => __('system.members.menu')]) }}
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end table -->
                    </div>
                    <!-- end table responsive -->
                </div>
            </div>
        </div>
    </div>
@endsection
@push('page_scripts')
    <!-- init js -->
    <script src="{{asset('assets/js/pages/form-advanced.init.js')}}"></script>
@endpush
