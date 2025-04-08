@extends('layouts.app')
@section('title', __('system.vendors.edit.title'))
@section('content')
    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('system.vendors.edit.title') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item "><a href="{{ route('admin.vendors.index') }}">{{ __('system.vendors.title') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.vendors.edit.title') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($errors->any())
                    {{ implode('', $errors->all('<div>:message</div>')) }}
                @endif
                {!! html()->modelForm($vendor,'PUT',  route('admin.vendors.update', $vendor->id))
                 ->id('pristine-valid')
                 ->attribute('enctype', 'multipart/form-data')
                 ->open() !!}

                <div class="card-body">
                    @if (request()->query->has('back'))
                        <input type="hidden" name="back" value="{{ request()->query->get('back') }}">
                    @endif
                    @include('admin.vendors.fields')
                </div>
                <div class="card-footer bg-transparent border-top text-muted">
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">{{ __('system.crud.save') }}</button>
                            <a href="{{ route('admin.vendors.index') }}" class="btn btn-secondary">{{ __('system.crud.cancel') }}</a>
                        </div>
                    </div>
                </div>
                {!! html()->closeModelForm() !!}
                <!-- end card -->
            </div>
        </div>
    </div>
@endsection
