@extends('layouts.app')
@section('title', __('system.dashboard.menu'))
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mx-auto">
                <div class="card-header text-center bg-primary text-white">
                    Email Verification
                </div>
                <div class="card-body">
                    <p class="card-text">Thank you for signing up! Please verify your email address.</p>
                    <!-- Add your verification message content here -->

                    <button type="button" class="btn btn-danger btn-block" onclick="logout()">Logout</button>
                </div>
            </div>
        </div>
    </div>
@endsection
