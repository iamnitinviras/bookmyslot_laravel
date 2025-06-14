@php($languages_array = getAllLanguages(true))
@extends('layouts.app', ['languages_array' => $languages_array])
@section('title', __('system.dashboard.frontend'))
@section('content')
<div class="row">

    <div class="col-xl-12 col-sm-12">
        <div class="card">
            <div class="card-header">

                <div class="row">
                    <div class="col-md-6 col-xl-6">
                        <h4 class="card-title">{{ __('system.dashboard.frontend') }}</h4>
                        <div class="page-title-box pb-0 d-sm-flex">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a
                                            href="{{ url('setting') }}">{{ __('system.environment.menu') }}</a></li>
                                    <li class="breadcrumb-item active">{{ __('system.dashboard.frontend') }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form autocomplete="off" novalidate="" action="{{ route('admin.environment.frontend.images') }}"
                id="pristine-valid" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @method('put')
                            @csrf
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="card">
                                        @php($lbl_banner_image_one = __('system.fields.banner_image_one'))
                                        <div class="card-header">{{$lbl_banner_image_one}}</div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <div class="d-flex align-items-center ">
                                                    <img src="{{ asset(config('custom.banner_image_one')) }}" alt=""
                                                        class="avatar-xl  preview-image_21 avater-120-contain">
                                                </div>
                                                @error('banner_image_one')
                                                    <div class="pristine-error text-help px-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="card-footer bg-transparent border-top text-muted">
                                            <input type="file" name="banner_image_one" id="banner_image_one"
                                                class="d-none my-preview" accept="image/*"
                                                data-pristine-accept-message="{{ __('validation.enum', ['attribute' => strtolower($lbl_banner_image_one)]) }}"
                                                data-preview='.preview-image_21'>
                                            <label for="banner_image_one" class="mb-0">
                                                <div for="profile-image"
                                                    class="btn btn-outline-primary waves-effect waves-light my-2 mdi mdi-upload ">
                                                    <span class="d-none d-lg-inline"> {{ $lbl_banner_image_one }}</span>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    @php($lbl_banner_image_two = __('system.fields.banner_image_two'))
                                    <div class="card">
                                        <div class="card-header">{{$lbl_banner_image_two}}</div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <div class="d-flex align-items-center ">
                                                    <img src="{{ asset(config('custom.banner_image_two')) }}" alt=""
                                                        class="avatar-xl  preview-image_22 avater-120-contain">
                                                </div>
                                                @error('banner_image_two')
                                                    <div class="pristine-error text-help px-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="card-footer bg-transparent border-top text-muted">
                                            <input type="file" name="banner_image_two" id="banner_image_two"
                                                class="d-none my-preview" accept="image/*"
                                                data-pristine-accept-message="{{ __('validation.enum', ['attribute' => strtolower($lbl_banner_image_two)]) }}"
                                                data-preview='.preview-image_22'>
                                            <label for="banner_image_two" class="mb-0">
                                                <div for="profile-image"
                                                    class="btn btn-outline-primary waves-effect waves-light my-2 mdi mdi-upload ">
                                                    <span class="d-none d-lg-inline"> {{ $lbl_banner_image_two }}</span>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top text-muted">
                    <div class="row">
                        <div class="col-12 mt-3">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>
                                {{ __('system.crud.save') }}</button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- end card -->
        </div>
    </div>
</div>
@endsection
