@php($languages_array = getAllLanguages(true))
@extends('layouts.app', ['languages_array' => $languages_array])
@section('title', __('system.environment.preferred_settings'))
@section('content')
    <div class="row">

        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('system.environment.preferred_settings') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item">
                                            <a href="{{ url('setting') }}">{{ __('system.environment.menu') }}</a>
                                        </li>
                                        <li class="breadcrumb-item active">{{ __('system.environment.preferred_settings') }}
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form autocomplete="off" novalidate="" action="{{ route('admin.environment.setting.preferred.update') }}"
                    id="pristine-valid" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                @method('put')
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label class="form-label"
                                                for="enable_faq">{{ trans('system.faq.title') }}</label>
                                            <select id="enable_faq" name="enable_faq" required class="form-control">
                                                <option {{ config('custom.enable_faq') == 'enable' ? 'selected' : '' }}
                                                    value="enable">
                                                    {{ trans('system.payment_setting.enable') }}
                                                </option>
                                                <option {{ config('custom.enable_faq') == 'disable' ? 'selected' : '' }}
                                                    value="disable">
                                                    {{ trans('system.payment_setting.disable') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label class="form-label"
                                                for="enable_testimonial">{{ trans('system.testimonial.title') }}</label>
                                            <select id="enable_testimonial" name="enable_testimonial" required class="form-control">
                                                <option {{ config('custom.enable_testimonial') == 'enable' ? 'selected' : '' }}
                                                    value="enable">
                                                    {{ trans('system.payment_setting.enable') }}
                                                </option>
                                                <option {{ config('custom.enable_testimonial') == 'disable' ? 'selected' : '' }}
                                                    value="disable">
                                                    {{ trans('system.payment_setting.disable') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label class="form-label"
                                                for="enable_blog">{{ trans('system.blogs.menu') }}</label>
                                            <select id="enable_blog" name="enable_blog" required class="form-control">
                                                <option {{ config('custom.enable_blog') == 'enable' ? 'selected' : '' }}
                                                    value="enable">
                                                    {{ trans('system.payment_setting.enable') }}
                                                </option>
                                                <option {{ config('custom.enable_blog') == 'disable' ? 'selected' : '' }}
                                                    value="disable">
                                                    {{ trans('system.payment_setting.disable') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top text-muted">
                        <div class="row">
                            <div class="col-12 mt-1">
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
