@extends('layouts.app')
@section('title', __('system.ticket_type.create.menu'))
@section('content')
    @php($ticket_type_setting='active')
    <div class="row">

        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-mb-8 col-xl-8">
                            <h4 class="card-title">{{ __('system.ticket_type.create.menu') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item "><a href="{{ route('admin.ticket-types.index') }}">{{ __('system.ticket_type.title') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.ticket_type.create.menu') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <form autocomplete="off" novalidate="" action="{{ route('admin.ticket-types.store') }}" id="pristine-valid" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        @include('admin.vendors_setting.nav')
                        <div class="row">
                            <div class="col-md-12">
                                @include('admin.vendors_setting.ticket_type.fields')
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top text-muted">
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">{{ __('system.crud.save') }}</button>
                                <a href="{{ route('admin.ticket-types.index') }}"class="btn btn-secondary">{{ __('system.crud.cancel') }}</a>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- end card -->
            </div>
        </div>
    </div>
@endsection
