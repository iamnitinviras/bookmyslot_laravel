@extends('layouts.app')
@section('title', __('system.branch.update.menu', ['branch' => strtolower($branch->title)]))
@section('content')
    <div class="row">

        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('system.branch.update.menu', ['board' => strtolower($branch->title)]) }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item "><a href="{{ route('admin.branch.index') }}">{{ __('system.branch.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.branch.update.menu', ['board' => strtolower($branch->title)]) }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! html()->modelForm($branch,'PUT',  route('admin.branch.update', $branch->id))
                 ->id('pristine-valid')
                 ->attribute('enctype', 'multipart/form-data')
                 ->open() !!}
                <div class="card-body">
                    @if (request()->query->has('back'))
                        <input type="hidden" name="back" value="{{ request()->query->get('back') }}">
                    @endif
                    @include('admin.branch.fields')
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> {{ __('system.crud.save') }}</button>
                            <a href="{{ request()->query->get('back', null) ?? route('admin.branch.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> {{ __('system.crud.cancel') }}</a>
                        </div>
                    </div>
                </div>
                {!! html()->closeModelForm() !!}
            </div>
        </div>
    </div>
@endsection
