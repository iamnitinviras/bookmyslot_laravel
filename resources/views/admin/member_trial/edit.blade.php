@extends('layouts.app')
@section('title', __('system.member_trial.update.menu'))
@section('content')
    <div class="row">

        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('system.member_trial.update.menu') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item "><a href="{{ route('admin.member-trial.index') }}">{{ __('system.members.trial') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.member_trial.update.menu') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! html()->modelForm($member_trial,'PUT',  route('admin.member-trial.update', $member_trial->id))
                 ->id('pristine-valid')
                 ->attribute('enctype', 'multipart/form-data')
                 ->open() !!}

                <div class="card-body">
                    <div class="card-body">
                        @if (request()->query->has('back'))
                            <input type="hidden" name="back" value="{{ request()->query->get('back') }}">
                        @endif
                        @include('admin.member_trial.fields')
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top text-muted">
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> {{ __('system.crud.save') }}</button>
                            <a href="{{ route('admin.member-trial.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> {{ __('system.crud.cancel') }}</a>
                        </div>
                    </div>
                </div>
                {!! html()->closeModelForm() !!}
                <!-- end card -->
            </div>
        </div>
    </div>
@endsection
