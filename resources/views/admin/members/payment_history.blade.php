@extends('layouts.app')
@section('title', __('system.fields.payment_history'))
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ trans('system.fields.payment_history') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{trans('system.fields.payment_history') }}</li>
                                    </ol>
                                </div>
                            </div>
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
                                            <th scope="col">{{trans('system.packages.title')}}</th>
                                            <th scope="col">{{trans('system.fields.price')}}</th>
                                            <th scope="col">
                                                <div class="d-flex justify-content-between w-100px">
                                                    @sortablelink('created_at', __('system.fields.payment_date'), [], ['class' => 'w-100 text-gray'])
                                                </div>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($payment_history as $ppayment)
                                            <tr>
                                                <td>{{ $ppayment->member->gym_customer_id }}</td>
                                                <td>{{ $ppayment->member->name}}</td>
                                                <td>{{ $ppayment->member->phone_number }}</td>
                                                <td>{{ $ppayment->package->local_lang_name }}</td>
                                                <td>{{ $ppayment->amount_paid  }}</td>
                                                <td>{{ $ppayment->created_at }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">
                                                    {{ __('system.crud.data_not_found', ['table' => __('system.fields.payment_history')]) }}
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
