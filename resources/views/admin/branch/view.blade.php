@extends('layouts.app')
@section('title', __('system.products.view.menu'))

@push('page_css')
    <style>
        .page-content {
            padding-left: 0px !important;
            padding-right: 0px !important;
        }
        .d-last-end {
            justify-content: end;
            align-items: end;
            display: inline-flex;
        }
    </style>
@endpush
@section('content')


    <div class="row">
        <div class="col-xl-12">
            <div class="profile-user"></div>
        </div>
    </div>

    <div class="row">
        <div class="profile-content">
            <div class="row align-items-end">
                <div class="col-sm">
                    <div class="d-flex align-items-end mt-3 mt-sm-0">
                        <div class="flex-shrink-0">
                            @if ($product->logo_url != null)
                                <div class="avatar-xxl me-3 ">

                                    <img data-src="{{ $product->logo_url }}" alt="" class="img-fluid rounded-circle d-block img-thumbnail lazyload h-120px">
                                </div>
                            @else
                                <div class="avatar-xxl me-3 d-last-end ">
                                    <h1 class="rounded-circle font-size text-white d-inline-block text-bold bg-primary text-center h-w-lh-120px">{{ $product->logo_name }}
                                    </h1>
                                </div>
                            @endif


                        </div>
                        <div class="flex-grow-1">
                            <div>
                                <h5 class="font-size-16 mb-1">{{ $product->name }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-auto">
                    <div class="d-flex align-items-start justify-content-end gap-2 mb-2">
                        <div>
                            {!! html()->modelForm($branch,'PUT',  route('admin.default.board', $branch->id))
                 ->id('pristine-valid')
                 ->attribute('enctype', 'multipart/form-data')
                 ->open() !!}
                            <form
                                action="{{ route('admin.default.board', ['board' => $product->id]) }}"
                                method="POST"
                                autocomplete="off"
                            >
                            @csrf
                            @method('PUT')
                            <a href="{{ route('admin.boardes.index') }}" role="button" class="btn btn-secondary "><i class="me-1"></i>{{ __('system.crud.back') }}</a>
                            <input type="hidden" name='back' value="{{ request()->fullurl() }}">
                            <button type="submit" class="btn btn-primary {{ auth()->user()->branch_id == $product->id ? 'disabled' : '' }}"><i class="me-1"></i>{{ __('system.boardes.set_default') }}</button>
                            {!! html()->closeModelForm() !!}
                        </div>
                        <div>
                            @if (auth()->user()->user_type == App\Models\User::USER_TYPE_ADMIN)
                            <form
                            action="{{ route('admin.boardes.destroy', ['board' => $product->id]) }}"
                            method="POST"
                            class="data-confirm"
                            data-confirm-message="{{ __('system.boardes.are_you_sure', ['name' => $product->name]) }}"
                            data-confirm-title="{{ __('system.crud.delete') }}"
                            id="delete-form_{{ $product->id }}"
                            autocomplete="off"
                        >
                            @csrf
                            @method('DELETE')
                            {!! html()->closeModelForm() !!}
                            @endif
                            <div class="dropdown">
                                <button class="btn btn-link font-size-16 shadow-none text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-horizontal-rounded font-size-20"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('admin.boardes.edit', ['board' => $product->id, 'back' => request()->fullurl()]) }}">{{ __('system.crud.edit') }}</a></li>
                                    @if (auth()->user()->branch_id != $product->id && auth()->user()->user_type == App\Models\User::USER_TYPE_ADMIN)
                                        <li><a class="dropdown-item" role="button" data-delete='#delete-form_{{ $product->id }}'>{{ __('system.crud.delete') }}</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row mt-3">
        <div class="col-xl-8 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('system.fields.about') }}</h5>
                </div>

                <div class="card-body">
                    <div>
                        <div class="pb-3">
                            <h5 class="font-size-15">{{ __('system.fields.contact_details') }}:</h5>
                            <div class="text-muted">
                                <dl class="row mb-0">
                                    <div class="col-md-6">
                                        <dt class="col-sm-4">{{ __('system.fields.board_name') }}</dt>
                                        <dd class="col-sm-8">{{ $product->name }}</dd>
                                    </div>
                                    <div class="col-md-6">
                                        <dt class="col-sm-4">{{ __('system.fields.phone_number') }}</dt>
                                        <dd class="col-sm-8">{{ $product->phone_number ?? '-' }}</dd>
                                    </div>
                                    <div class="col-md-6">
                                        <dt class="col-sm-4">{{ __('system.fields.email') }}</dt>
                                        <dd class="col-sm-8">{{ $product->contact_email ?? '-' }}</dd>
                                    </div>

                                </dl>
                            </div>
                        </div>

                        <div class="pt-3">
                            <h5 class="font-size-15">{{ __('system.fields.address_details') }}:</h5>
                            <div class="text-muted">
                                <dl class="row mb-0">
                                    <div class="col-md-6">
                                        <dt class="col-sm-4">{{ __('system.fields.city') }}</dt>
                                        <dd class="col-sm-8">{{ $product->city ?? '-' }}</dd>
                                    </div>
                                    <div class="col-md-6">
                                        <dt class="col-sm-4">{{ __('system.fields.state') }}</dt>
                                        <dd class="col-sm-8">{{ $product->state ?? '-' }}</dd>
                                    </div>
                                    <div class="col-md-6">
                                        <dt class="col-sm-4">{{ __('system.fields.country') }}</dt>
                                        <dd class="col-sm-8">{{ $product->country ?? '-' }}</dd>
                                    </div>
                                    <div class="col-md-6">
                                        <dt class="col-sm-4">{{ __('system.fields.address') }}</dt>
                                        <dd class="col-sm-8">{{ $product->address ?? '-' }}</dd>
                                    </div>

                                </dl>
                            </div>
                        </div>

                        <div class="pt-3">
                            <h5 class="font-size-15">{{ __('system.fields.created_by') }}:</h5>
                            <div class="text-muted">
                                <dl class="row mb-0">
                                    <div class="col-md-6">
                                        <dt class="col-sm-4">{{ __('system.fields.name') }}</dt>
                                        <dd class="col-sm-8">{{ $product->created_user->name }}</dd>
                                    </div>
                                    <div class="col-md-6">
                                        <dt class="col-sm-4">{{ __('system.fields.email') }}</dt>
                                        <dd class="col-sm-8">{{ $product->created_user->email ?? '-' }}</dd>
                                    </div>
                                    <div class="col-md-6">
                                        <dt class="col-sm-4">{{ __('system.fields.phone_number') }}</dt>
                                        <dd class="col-sm-8">{{ $product->created_user->phone_number ?? '-' }}</dd>
                                    </div>
                                    <div class="col-md-6">
                                        <dt class="col-sm-4">{{ __('system.fields.date_time') }}</dt>
                                        <dd class="col-sm-8">{{ $product->created_at }}</dd>
                                    </div>

                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end tab content -->
        </div>
        <!-- end col -->

        <div class="col-xl-4  col-lg-4">

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('system.fields.staffs') }}</h5>
                </div>

                <div class="card-body">
                    <div class="mb-4 overflow-auto">
                        <table class="table align-middle">
                            <tbody>
                                @if ($product->users)
                                    @foreach ($product->users as $user)
                                        <tr>
                                            <td class="w-50px">
                                                @if ($user->profile_url != null)
                                                    <img data-src="{{ $user->profile_url }}" alt="" class="avatar-sm rounded-circle me-2 lazyload">
                                                @else
                                                    <div class="avatar-sm d-inline-block align-middle me-2">
                                                        <div class="avatar-title bg-soft-primary text-primary font-size-18 m-0 rounded-circle font-weight-bold">
                                                            {{ $user->logo_name }}
                                                        </div>
                                                    </div>
                                                @endif

                                            </td>
                                            <td>
                                                <h5 class="font-size-14 m-0"><a href="javascript: void(0);" class="text-dark">{{ $user->name }}</a></h5>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ $user->email }}
                                                </div>
                                            </td>
                                            <td>
                                                {{ $user->phone_number }}
                                            </td>
                                            @if ($product->id == auth()->user()->branch_id || auth()->user()->user_type == App\Models\User::USER_TYPE_ADMIN)
                                                <td>

                                                    <a role="button" @if (auth()->user()->id == $user->id) href="{{ route('admin.profile') }}"  @else href="{{ route('admin.staff.edit', $user->id) }}" @endif
                                                        class="btn btn-success">{{ __('system.crud.edit') }}</a>

                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach

                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->


@endsection
