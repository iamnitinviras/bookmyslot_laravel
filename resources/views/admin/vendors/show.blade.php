@extends('layouts.app')
@section('title', __('system.fields.view'))
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
                                        <li class="breadcrumb-item active">
                                            {{ $vendor->first_name . ' ' . $vendor->last_name }}
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-6 text-end">
                            <a href="{{ route('admin.vendors.index') }}"
                                class="btn text-muted d-none d-sm-inline-block btn-link">
                                <i class="mdi mdi-arrow-left me-1"></i>
                                {{ __('system.crud.back') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="row">
                            <!-- Profile Details -->
                            <div class="col-md-4">
                                <div class="card vendor_details_div_height">
                                    <div class="card-header">
                                        {{ __('system.profile.profile_details') }}
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p class="font12"><b>{{ __('system.fields.name') }}</b>:
                                                    {{ $vendor->first_name . ' ' . $vendor->last_name }}
                                                </p>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="font12"><b>{{ __('system.fields.email') }}</b>:
                                                    {{ $vendor->email }}
                                                </p>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="font12"><b>{{ __('system.fields.phone_number') }}</b>:
                                                    {{ $vendor->phone_number }}
                                                </p>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="font12"><b>{{ __('system.fields.member_since') }}</b>:
                                                    {{ $vendor->created_at }}
                                                </p>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="font12"><b>{{ __('system.fields.address') }}</b>:
                                                    {{ $vendor->address }}{{ $vendor->city ? ", " . $vendor->city : "" }}{{ $vendor->state ? ", " . $vendor->state : "" }}{{ $vendor->zip ? ", " . $vendor->zip : "" }}
                                                </p>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="card-footer bg-transparent border-top text-muted btn-group btn-group-sm">
                                        @if($vendor->email_verified_at==null)
                                            {!! html()->form('post', route('admin.vendors.verify.email', ['vendor' => $vendor->id]))
                                            ->class('data-confirm')
                                            ->attribute('autocomplete', 'off')
                                            ->attribute('data-confirm-message', __('system.fields.confirm_vendor_email'))
                                            ->attribute('data-confirm-title', __('system.crud.verify_email'))
                                            ->id('verify_email-form_' . $vendor->id)->open() !!}
                                            <button type="submit"
                                                class="btn btn-success me-1"><i class="fa fa-check-circle"></i> {{ __('system.crud.verify_email') }}</button>
                                            {!! html()->closeModelForm() !!}
                                        @endif

                                        @if ($vendor->status == 'active')
                                            {!! html()->form('post', route('admin.vendors.make.inactive', ['vendor' => $vendor->id]))
                                            ->class('data-confirm')
                                            ->attribute('autocomplete', 'off')
                                            ->attribute('data-confirm-message', __('system.fields.confirm_make_inactive'))
                                            ->attribute('data-confirm-title', __('system.crud.inactive'))
                                            ->id('inactive-form_' . $vendor->id)->open() !!}
                                            <button type="submit"
                                                class="btn btn-danger"><i class="fas fa-ban"></i> {{ __('system.crud.make_inactive') }}</button>
                                            {!! html()->closeModelForm() !!}
                                        @else
                                            {!! html()->form('post', route('admin.vendors.make.active', ['vendor' => $vendor->id]))
                                            ->class('data-confirm')
                                            ->attribute('autocomplete', 'off')
                                            ->attribute('data-confirm-message', __('system.fields.confirm_make_active'))
                                            ->attribute('data-confirm-title', __('system.crud.active'))
                                            ->id('active-form_' . $vendor->id)->open() !!}
                                            <button type="submit"
                                                class="btn btn-success"><i class="fa fa-check-circle"></i> {{ __('system.crud.make_active') }}</button>
                                            {!! html()->closeModelForm() !!}
                                        @endif

                                    </div>
                                </div>
                            </div>

                            <!-- Profile Details -->
                            @if($vendor->free_forever == false)
                                <div class="col-md-4">
                                    <div class="card vendor_details_div_height">
                                        <div class="card-header">
                                            {{ __('system.plans.subscriptions') }}
                                        </div>
                                        <div class="card-body">

                                            @if (isset($current_plans->payment_method) && $current_plans->payment_method != 'Trial')
                                                <div class="col-md-12">
                                                    <p class="font12"><b>{{ __('system.plans.title') }}</b>:
                                                        @if (isset($plans->title))
                                                            {{ $plans->local_title }}
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="col-md-12">
                                                    <p class="font12"><b>{{ __('system.plans.amount') }}</b>:
                                                        @if (isset($plans->amount))
                                                            {{ displayCurrency($plans->amount) }}
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="col-md-12">
                                                    <p class="font12"><b>{{ __('system.plans.recurring_type') }}</b>:
                                                        @if (isset($plans->type))
                                                            {{ __('system.plans.' . $plans->type) }}
                                                        @endif
                                                    </p>
                                                </div>
                                            @endif

                                            <div class="col-md-12">
                                                <p class="font12"><b>{{ __('system.plans.payment_method') }}</b>:
                                                    @if (isset($current_plans->payment_method))
                                                        {{ trans('system.payment_setting.' . $current_plans->payment_method)}}
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="col-md-12">
                                                <p class="font12"><b>{{ __('system.plans.start_date') }}</b>:
                                                    @if (isset($current_plans->start_date))
                                                        {{ formatDate($current_plans->start_date) }}
                                                    @endif
                                                </p>
                                            </div>

                                            @if($current_plans->type !== "onetime")
                                                <div class="col-md-12">
                                                    <p class="font12"><b>{{ __('system.plans.expiry_date') }}</b>:
                                                        @if (isset($current_plans->expiry_date))
                                                            {{ formatDate($current_plans->expiry_date) }}
                                                        @endif
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-footer bg-transparent border-top text-muted">
                                            <a href="{{ route('admin.vendors.paymentTransactions', $vendor->id) }}"
                                                class="btn btn-outline-primary">
                                                <i class="fas fa-list-ul"></i> {{ __('system.payment_setting.payment_history') }}
                                            </a>
                                            <a href="{{ route('admin.vendors.changePlan', $vendor->id) }}"
                                                class="btn btn-outline-secondary">
                                                <i class="fas fa-exchange-alt"></i> {{ __('system.plans.change_plan') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Profile Details -->
                            <div class="col-md-4">
                                <form method="post" autocomplete="off" novalidate="" id="pristine-valid"
                                    action="{{ route('admin.vendors.password.update', ['vendor' => $vendor->id]) }}">
                                    <div class="card vendor_details_div_height">
                                        <div class="card-header">
                                            {{ __('system.password.menu') }}
                                        </div>
                                        <div class="card-body">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <div class="form-group">
                                                        <label>{{ __('system.fields.new_password') }}</label>
                                                        <input autocomplete="off" value="{{old('new_password')}}"
                                                            id="new_password" required name="new_password"
                                                            placeholder="{{ __('system.fields.new_password') }}"
                                                            minlength="8" class="form-control" />
                                                    </div>
                                                    @error('new_password')
                                                        <div class="pristine-error text-help">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12 mb-5">
                                                    <div class="form-group">
                                                        <label>{{ __('system.fields.confirm_password') }}</label>
                                                        <input autocomplete="off" value="{{old('confirm_password')}}"
                                                            data-pristine-equals-message="{{ __('system.password.confirm_password_error') }}"
                                                            data-pristine-equals="#new_password" id="confirm_password"
                                                            required name="confirm_password"
                                                            placeholder="{{ __('system.fields.confirm_password') }}"
                                                            minlength="8" class="form-control" />
                                                    </div>
                                                    @error('confirm_password')
                                                        <div class="pristine-error text-help">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>
                                        <div class="card-footer bg-transparent border-top text-muted">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ __('system.password.menu') }}</button>
                                            </div>
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
@endsection
