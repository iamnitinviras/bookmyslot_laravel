@extends('layouts.app')
@section('title', __('system.members.update.menu'))
@section('content')
    <div class="row">

        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('system.members.update.menu') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item "><a href="{{ route('admin.members.index') }}">{{ __('system.members.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.members.update.menu') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! html()->modelForm($member,'PUT',  route('admin.members.update', $member->id))
                 ->id('pristine-valid')
                 ->attribute('enctype', 'multipart/form-data')
                 ->open() !!}

                <div class="card-body">
                    @if (request()->query->has('back'))
                        <input type="hidden" name="back" value="{{ request()->query->get('back') }}">
                    @endif
                    @include('admin.members.fields')
                </div>
                <div class="card-footer bg-transparent border-top text-muted">
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">{{ __('system.crud.save') }}</button>
                            <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">{{ __('system.crud.cancel') }}</a>
                        </div>
                    </div>
                </div>
                {!! html()->closeModelForm() !!}
                <!-- end card -->
            </div>
        </div>
    </div>
@endsection
