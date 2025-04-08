@extends('layouts.app')
@section('title', __('system.members.attendance'))
@section('content')

    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('system.members.attendance') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.members.attendance') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <form method="get" action="{{route('admin.attendance')}}">
                            <div class="col-md-6 offset-3 text-center">
                                <input type="text" name="member" value="{{request()->member}}" required autofocus class="form-control" placeholder="Search...">
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="text-md-center">
                                    <a href="{{route('admin.attendance')}}" class="btn btn-secondary btn-rounded waves-effect waves-light mb-2 me-2">
                                        <i class="bx bx-reset search-icon"></i>
                                        {{ __('system.crud.reset') }}
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-rounded waves-effect waves-light mb-2 me-2">
                                        <i class="bx bx-search-alt search-icon"></i>
                                        Search member
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
{{--                    <div class="row">--}}
{{--                        <div class="col-md-12">--}}
{{--                            @if(isset($member) && $member!=null)--}}
{{--                                <form autocomplete="off" novalidate="" action="{{ route('admin.submit.attendance',['member'=>$member->id]) }}" id="pristine-valid" method="post" enctype="multipart/form-data">--}}
{{--                                <div class="card">--}}
{{--                                    @csrf--}}
{{--                                    <input type="hidden" name="gym_customer_id" value="{{$member->id}}">--}}
{{--                                    <div class="card-header">--}}
{{--                                        {{trans('system.members.title')}}--}}
{{--                                    </div>--}}
{{--                                    <div class="card-body">--}}
{{--                                        <div class="d-flex align-items-center">--}}
{{--                                            <div class="flex-1">--}}
{{--                                                <h5 class="font-size-15 mb-1">{{$member->name}}</h5>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="mt-3 pt-1">--}}
{{--                                            <p class="text-muted mb-0">--}}
{{--                                                <i class="mdi mdi-phone font-size-15 align-middle pe-2 text-primary"></i>--}}
{{--                                                {{$member->phone_number}}--}}
{{--                                            </p>--}}
{{--                                            <p class="text-muted mb-0 mt-2"><i class="mdi mdi-email font-size-15 align-middle pe-2 text-primary"></i>--}}
{{--                                                {{$member->email}}--}}
{{--                                            </p>--}}
{{--                                            @if($member->address!=null)--}}
{{--                                                <p class="text-muted mb-0 mt-2">--}}
{{--                                                    <i class="mdi mdi-google-maps font-size-15 align-middle pe-2 text-primary"></i>--}}
{{--                                                    {{$member->address}}--}}
{{--                                                </p>--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="btn-group" role="group">--}}
{{--                                        <a href="{{route('admin.attendance')}}" class="btn btn-outline-secondary text-truncate gap-1"><i class="uil uil-user me-1"></i> {{trans('system.crud.cancel')}}</a>--}}
{{--                                        <button type="submit" class="btn btn-outline-primary text-truncate"><i class="uil uil-envelope-alt me-1"></i> {{trans('system.members.mark_attendance')}}</button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                </form>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection
