@extends('layouts.app')
@section('title', __('system.cms.edit.title'))
@section('content')
    <div class="row">

        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-mb-8 col-xl-8">
                            <h4 class="card-title">{{ __('system.cms.edit.title') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item "><a
                                                href="{{ route('admin.cms-page.index') }}">{{ __('system.cms.pages') }}</a>
                                        </li>
                                        <li class="breadcrumb-item active">{{ __('system.cms.edit.title') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 text-end">

                        </div>
                    </div>
                </div>

                {!! html()->modelForm($cmsPage, 'put', route('admin.cms-page.update', $cmsPage->id))
        ->attribute('files', true)
        ->attribute('novalidate', true)
        ->open() !!}
                @if (request()->query->has('back'))
                    <input type="hidden" name="back" value="{{ request()->query->get('back') }}">
                @endif
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @include('admin.cms_page.fields', ['edit' => true])
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top text-muted">
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> {{ __('system.crud.save') }}</button>
                            <a href="{{ route('admin.cms-page.index') }}"
                                class="btn btn-secondary"><i class="fa fa-arrow-left"></i> {{ __('system.crud.back') }}</a>
                        </div>
                    </div>
                </div>
                {!! html()->closeModelForm() !!}
            </div>
        </div>
    </div>
@endsection
