<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <div class="navbar-brand-box">
                <a href="{{ route('home') }}" class="logo logo-light">
                            <span class="logo-sm">
                                <img class="lazyload" src="{{ asset(config('custom.favicon_icon')) }}" alt="{{config('app.name')}}" height="30">
                            </span>
                    <span class="logo-lg">
                                <img class="lazyload" src="{{ asset(config('custom.logo')) }}" alt="{{config('app.name')}}" height="60">
                            </span>
                </a>

                <a href="{{ route('home') }}" class="logo logo-dark">
                            <span class="logo-sm">
                                <img class="lazyload" src="{{ asset(config('custom.favicon_icon')) }}" alt="{{config('app.name')}}" height="30">
                            </span>
                    <span class="logo-lg">
                                <img class="lazyload" src="{{ asset(config('custom.logo')) }}" alt="{{config('app.name')}}" height="60">
                            </span>
                </a>
            </div>
            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            @php($act_branches = App\Http\Controllers\HomeController::getCurrentUsersAllBranch())
            @if(isset($act_branches) && count($act_branches)>0)
                @foreach ($act_branches as $act_branch)

                    {!! html()->form('put', route('admin.default.branch', ['branch' => $act_branch->id]))
                    ->class('d-none')
                    ->attribute('autocomplete', 'off')
                    ->id('default_board__' . $act_branch->id) !!}

                    <input type="hidden" name='back' value="{{ request()->fullurl() }}">

                    {!! html()->closeModelForm() !!}
                @endforeach
            @endif

            <!-- Business Change-->
            @hasanyrole('staff|vendor')
            @if (auth()->user()->branch != null)
                <form class="app-search d-none d-lg-block">
                    <div class="position-relative">
                        <div class="dropdown">
                            <div class="input-group" style="background:#ffc107;border-radius: 10px;">
                                <input readonly style="color: #000; font-weight: bold;" autocomplete="off" type="text" id="current_user_board" class="form-control" value="{{ auth()->user()->branch->title }}"/>
                            </div>
                            @if(isset($act_branches) && count($act_branches)>1)
                                <button class="btn btn-primary dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-chevron-down text-white align-middle"></i>
                                </button>
                                <ul id="change_board_dropdown" class="dropdown-menu dropdown-menu-end">
                                    @foreach ($act_branches as $act_branch)
                                        @if (auth()->user()->branch_id != $act_branch->id)
                                            <li>
                                                <a onclick="event.preventDefault(); document.getElementById('default_board_{{ $act_branch->id }}').submit();" href="javascript:void(0)"
                                                   class="dropdown-item"><i class="mdi mdi-city-variant-outline font-size-16 text-success me-1"></i> {{ $act_branch->title }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </form>
            @endif
            @endhasanyrole
        </div>

        <div class="d-flex">
            <div class="dropdown ">
                @hasanyrole('Super-Admin')
                <div class="dropdown d-inline-block">
                    <a href="{{ route('/') }}" target="_blank" class="btn">
                        <i class="font-size-16 fas fa-external-link-alt ms-2 " aria-hidden="true"></i>
                    </a>
                </div>
                @else
                    @hasanyrole('vendor')
                    @if(Session::has('super_admin_id'))
                        <a href="{{route('admin.vendors.vendorLogout')}}" target="_self" class="btn btn-danger">
                            <i class="font-size-16 fas fa-times-circle" aria-hidden="true"></i> {{trans('system.fields.switch_to_admin')}}
                        </a>
                    @endif
                    @endhasanyrole

                    @endhasanyrole

                    <div class="dropdown d-none d-sm-inline-block">
                        <button type="button" class="btn header-item" id="mode-setting-btn">
                            <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                            <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                        </button>
                    </div>
                    <div class="dropdown d-inline-block ms-1">
                        <button type="button" class="btn header-item" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <h1 class="font-size-16 px-2 pt-2 header-item d-inline-block h-auto">
                                <i class="fas fa-language font-size-18"></i>
                            </h1>
                        </button>
                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                            <div class="p-2">
                                @if (!isset($languages_array))
                                    @php($languages_array = getAllLanguages(true))
                                @endif
                                @foreach ($languages_array as $key => $language)
                                    <a class="dropdown-icon-item  @if (App::currentLocale() == $key) bg-light-gray  disabled @endif" @if (App::currentLocale() != $key) role="button"
                                       onclick="event.preventDefault(); document.getElementById('user_set_default_language{{ $key }}').submit();" @endif title="Set as Default">
                                        <div class="row g-0">
                                            <div class="col-12  text-start overflow-hidden">
                                                <h6 class="px-2">{{ $language }}</h6>
                                            </div>
                                        </div>
                                    </a>
                                    @if (App::currentLocale() != $key)
                                        {{ Form::open(['route' => ['admin.default.language', ['language' => $key]], 'method' => 'put', 'autocomplete' => 'off', 'class' => 'd-none', 'id' => 'user_set_default_language' . $key]) }}
                                        <input type="hidden" name='back' value="{{ request()->fullurl() }}">
                                        {{ Form::close() }}
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item bg-soft-light " id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                            @if (auth()->user()->profile_url != null)
                                <img data-src="{{ auth()->user()->profile_url }}" alt="" class="rounded-circle header-profile-user image-object-cover lazyload">
                            @else
                                <h1 class="rounded-circle header-profile-user font-size-18 px-2 pt-2 text-white d-inline-block font-bold">
                                    {{ auth()->user()->logo_name }}</h1>
                            @endif

                            <span class="d-none d-xl-inline-block ms-1 fw-medium">{{ auth()->user()->name }}</span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                <i class="mdi mdi-face-profile font-size-16 align-middle me-1"></i>
                                {{ __('system.profile.menu') }}
                            </a>
                            <div class="dropdown-divider"></div>

                            @role('vendor')
                            @if (auth()->user()->free_forever == false)
                                <a class="dropdown-item" href="{{ route('admin.vendor.payment.history') }}">
                                    <i class="mdi mdi-format-list-checks font-size-16 align-middle me-1"></i>
                                    {{ __('system.payment_setting.payment_history') }}
                                </a>
                                <div class="dropdown-divider"></div>
                            @endif
                            @endrole

                            <a class="dropdown-item" role="button" onclick="event.preventDefault(); document.getElementById('logout-form').click();"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i>
                                {{ __('auth.sign_out') }}
                            </a>
                            <form autocomplete="off" action="{{ route('logout') }}" method="POST" class="d-none data-confirm" data-confirm-message="{{ __('system.fields.logout') }}" data-confirm-title=" {{ __('auth.sign_out') }}">
                                <button id="logout-form" type="submit"></button>
                                @csrf
                            </form>
                        </div>
                    </div>

            </div>
        </div>
</header>

<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            @include('layouts.sidebar')
        </div>
    </div>
</div>
