@extends('layouts.app')
@section('title', __('system.fields.collect_payment'))
@section('content')

    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ trans('system.fields.collect_payment') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item active"><a href="{{ route('admin.pending.payment') }}">{{ trans('system.fields.pending_payment') }}</a></li>
                                        <li class="breadcrumb-item active">{{ trans('system.fields.collect_payment') }}</li>
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
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-3">{{trans('system.members.member_details')}}</h4>

                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>{{trans('system.fields.name')}}</td>
                                                        <td>{{$pending_payment->member->name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{trans('system.fields.phone_number')}}</td>
                                                        <td>{{$pending_payment->member->phone_number}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{trans('system.members.join_date')}}</td>
                                                        <td>{{$pending_payment->member->join_date}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{trans('system.members.package_end_date')}}</td>
                                                        <td>{{$pending_payment->member->package_end_date}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- end table-responsive -->
                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
                            <div class="col-xl-8">
                                {!! html()->modelForm($pending_payment,'PUT',  route('admin.submit.part.payment', $pending_payment->id))
                                 ->id('pristine-valid')
                                 ->attribute('enctype', 'multipart/form-data')
                                 ->open()
                                !!}
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card">
                                            <div class="card-header">
                                                <p class="mb-0 font-size-18">{{trans('system.members.amount_pending')}}: {{$pending_payment->due_amount}}</p>
                                            </div>
                                            <div class="card-body">
                                                <input type="hidden" name="package_price" id="package_price" value="{{$pending_payment->due_amount}}"/>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        @php($lbl_payment_mode = __('system.members.payment_mode'))
                                                        <div class="mb-3 form-group">
                                                            <label class="form-label" for="payment_mode">{{ $lbl_payment_mode }} <span class="text-danger">*</span></label>
                                                            <select id="payment_mode" data-pristine-required-message="{{__('validation.required', ['attribute' => strtolower(trans('system.members.payment_mode'))])}}" name="payment_mode" class="form-control" required>
                                                                <option value="">{{$lbl_payment_mode}}</option>
                                                                <option {{ old('payment_mode') == 'cash' ? 'selected' : '' }} value="cash">{{ trans('system.members.cash') }}</option>
                                                                <option {{ old('payment_mode') == 'upi' ? 'selected' : '' }} value="upi">{{ trans('system.members.upi') }}</option>
                                                            </select>
                                                        </div>
                                                        @error('payment_mode')
                                                        <div class="pristine-error text-help">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-4">
                                                        @php($lbl_payment_type = __('system.members.payment_type'))
                                                        <div class="mb-3 form-group">
                                                            <label class="form-label" for="payment_type">{{ $lbl_payment_type }} <span class="text-danger">*</span></label>
                                                            <select id="payment_type" onchange="get_paid_amount_validation(this)" data-pristine-required-message="{{__('validation.required', ['attribute' => strtolower(trans('system.members.payment_type'))])}}" name="payment_type" class="form-control" required>
                                                                <option value="">{{$lbl_payment_type}}</option>
                                                                <option {{ old('payment_type') == 'full' ? 'selected' : '' }} value="full">{{ trans('system.members.full') }}</option>
                                                                <option {{ old('payment_type') == 'partial' ? 'selected' : '' }} value="partial">{{ trans('system.members.partial') }}</option>
                                                            </select>
                                                        </div>
                                                        @error('payment_type')
                                                        <div class="pristine-error text-help">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-4">
                                                        @php($lbl_amount_paid = __('system.members.amount_paid'))
                                                        <div class="mb-3 form-group @error('amount_paid') has-danger @enderror">
                                                            <label class="form-label" for="amount_paid">{{ $lbl_amount_paid }} <span class="text-danger">*</span></label>
                                                            {!! html()->number('amount_paid', old('amount_paid')??0 )
                                                            ->class('form-control')
                                                            ->id('amount_paid')
                                                            ->attribute('oninput','calculate_pending_amount(this)')
                                                            ->required()
                                                            ->attribute('placeholder', $lbl_amount_paid) !!}
                                                            @error('amount_paid')
                                                            <div class="pristine-error text-help">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 amount_pending_section d-none">
                                                        @php($lbl_amount_pending = __('system.members.amount_pending'))
                                                        <div class="mb-3 form-group @error('amount_pending') has-danger @enderror">
                                                            <label class="form-label" for="amount_pending">{{ $lbl_amount_pending }}</label>
                                                            {!! html()->number('amount_pending', old('amount_pending')??0 )
                                                            ->class('form-control')
                                                            ->id('amount_pending')
                                                            ->isReadonly()
                                                            ->attribute('placeholder', $lbl_amount_pending) !!}
                                                            @error('amount_pending')
                                                            <div class="pristine-error text-help">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-12">
                                                <button class="btn btn-primary" type="submit">{{ __('system.crud.save') }}</button>
                                                <a href="{{ route('admin.pending.payment') }}"class="btn btn-secondary">{{ __('system.crud.cancel') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {!! html()->closeModelForm() !!}
                            </div>
                        </div>
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
