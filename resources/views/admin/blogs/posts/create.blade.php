@extends('layouts.app')
@section('title', __('system.blogs.create.menu'))
@section('content')
    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-mb-8 col-xl-8">
                            <h4 class="card-title">{{ __('system.blogs.create.menu') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item "><a
                                                href="{{ route('admin.posts.index') }}">{{ __('system.blogs.posts') }}</a>
                                        </li>
                                        <li class="breadcrumb-item active">{{ __('system.blogs.create.menu') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <form autocomplete="off" novalidate="" action="{{ route('admin.posts.store') }}" id="pristine-valid"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                @include('admin.blogs.posts.fields')
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <div class="row">
                            <div class="col-12 mt-3">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-plus-circle"></i>
                                    {{ __('system.crud.save') }}</button>
                                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary"><i
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

@push('third_party_scripts')
    <!-- ckeditor -->
    <script src="{{ asset('assets/admin/libs/%40ckeditor/ckeditor5-build-classic/build/ckeditor.js')}}"></script>
    <!-- init js -->
    <script src="{{ asset('assets/admin/js/pages/form-editor.init.js')}}"></script>
@endpush
