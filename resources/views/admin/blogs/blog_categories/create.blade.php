@extends('layouts.app')
@section('title', __('system.blog_categories.create.menu'))
@section('content')
    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-mb-8 col-xl-8">
                            <h4 class="card-title">{{ __('system.blog_categories.create.menu') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item "><a
                                                href="{{ route('admin.blog-categories.index') }}">{{ __('system.blog_categories.menu') }}</a>
                                        </li>
                                        <li class="breadcrumb-item active">{{ __('system.blog_categories.create.menu') }}
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form autocomplete="off" novalidate="" action="{{ route('admin.blog-categories.store') }}"
                    id="pristine-valid" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                @include('admin.blogs.blog_categories.fields')
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top text-muted">
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-plus-circle"></i>
                                    {{ __('system.crud.save') }}</button>
                                <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-secondary"><i
                                        class="fa fa-arrow-left"></i> {{ __('system.crud.cancel') }}</a>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- end card -->
            </div>
        </div>
    </div>
@endsection
