@extends('layouts.app')
@section('title', __('system.ticket_type.update.menu'))
@section('content')
    @php($ticket_type_setting='active')
    <div class="row">

        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-mb-8 col-xl-8">
                            <h4 class="card-title">{{ __('system.ticket_type.update.menu') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item "><a href="{{ route('admin.ticket-types.index') }}">{{ __('system.ticket_type.title') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.ticket_type.update.menu') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{ Form::model($ticket_type, ['route' => ['admin.ticket-types.update', $ticket_type->id], 'method' => 'put', 'files' => true, 'id' => 'pristine-valid']) }}
                @if (request()->query->has('back'))
                    <input type="hidden" name="back" value="{{ request()->query->get('back') }}">
                @endif
                <div class="card-body">
                    @include('admin.vendors_setting.nav')
                    <div class="row">
                        <div class="col-md-12">
                            @include('admin.vendors_setting.ticket_type.fields', ['edit' => true])
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top text-muted">
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">{{ __('system.crud.save') }}</button>
                            <a href="{{ route('admin.ticket-types.index') }}"class="btn btn-secondary">{{ __('system.crud.back') }}</a>
                        </div>
                    </div>
                </div>
                {!! html()->closeModelForm() !!}

            </div>
        </div>
    </div>
@endsection
