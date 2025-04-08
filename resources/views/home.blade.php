@extends('layouts.app')
@section('title', __('system.dashboard.menu'))
@section('content')
    @if(auth()->user()->user_type===\App\Models\User::USER_TYPE_ADMIN)
        @include('admin.dashboard.admin')
    @else
        @include('admin.dashboard.vendor')
    @endif
@endsection
