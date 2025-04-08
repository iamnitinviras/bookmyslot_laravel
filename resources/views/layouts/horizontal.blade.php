<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <div class="navbar-brand-box">
                <a href="{{ route('home') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img class="lazyload" src="{{ asset(config('app.favicon_icon')) }}" alt="{{config('app.name')}}" height="30">
                    </span>
                    <span class="logo-lg">
                        <img class="lazyload" src="{{ asset(config('app.logo')) }}" alt="{{config('app.name')}}" height="60">
                    </span>
                </a>

                <a href="{{ route('home') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img class="lazyload" src="{{ asset(config('app.favicon_icon')) }}" alt="{{config('app.name')}}" height="30">
                    </span>
                    <span class="logo-lg">
                        <img class="lazyload" src="{{ asset(config('app.logo')) }}" alt="{{config('app.name')}}" height="60">
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
                                <input readonly style="color: #000; font-weight: bold;" autocomplete="off" type="text" id="current_user_board" class="form-control"
                                       value="{{ auth()->user()->branch->title }}"/>
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
                            <a class="dropdown-item" href="{{ route('admin.vendor.support') }}">
                                <i class="fas fa-hands-helping font-size-16 align-middle me-1"></i>
                                {{ __('system.fields.support') }}
                            </a>
                            <div class="dropdown-divider"></div>
                            @if (auth()->user()->free_forever == false)
                                <a class="dropdown-item" href="{{ route('admin.vendor.payment.history') }}">
                                    <i class="mdi mdi-format-list-checks font-size-16 align-middle me-1"></i>
                                    {{ __('system.payment_setting.payment_history') }}
                                </a>
                                <div class="dropdown-divider"></div>
                            @endif
                            @endrole

                            <a class="dropdown-item" role="button" onclick="event.preventDefault(); document.getElementById('logout-form').click();"><i
                                    class="mdi mdi-logout font-size-16 align-middle me-1"></i>
                                {{ __('auth.sign_out') }}
                            </a>
                            <form autocomplete="off" action="{{ route('logout') }}" method="POST" class="d-none data-confirm" data-confirm-message="{{ __('system.fields.logout') }}"
                                  data-confirm-title=" {{ __('auth.sign_out') }}">
                                <button id="logout-form" type="submit"></button>
                                @csrf
                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</header>
<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="{{ route('home') }}" id="topnav-dashboard" role="button">
                            <i data-feather="home"></i><span data-key="t-dashboard">{{ __('system.dashboard.menu') }}</span>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="javascript:void(0)" id="topnav-pages" role="button">
                            <i data-feather="users"></i><span data-key="t-apps">{{trans('system.members.menu')}}</span>
                            <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-pages">

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="member_add"
                                   role="button">
                                    <span data-key="t-ecommerce">{{trans('system.fields.add')}}</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="member_add">
                                    @can('add members_enquiry')
                                        <a href="{{ route('admin.member-enquiry.create') }}" class="dropdown-item" data-key="t-products">{{trans('system.members.enquiry')}}</a>
                                    @endcan
                                    @can('add members_trial')
                                        <a href="{{ route('admin.member-trial.create') }}" class="dropdown-item" data-key="t-products">{{trans('system.members.trial')}}</a>
                                    @endcan
                                    @can('add members')
                                        <a href="{{ route('admin.members.create') }}" class="dropdown-item" data-key="t-products">{{trans('system.members.title')}}</a>
                                    @endcan
                                </div>
                            </div>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="member_listing"
                                   role="button">
                                    <span data-key="t-ecommerce">{{trans('system.fields.list')}}</span>
                                    <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="member_listing">
                                    @can('show members_enquiry')
                                        <a href="{{ route('admin.member-enquiry.index') }}" class="dropdown-item" data-key="t-products">{{trans('system.members.enquiry')}}</a>
                                    @endcan
                                    @can('show members_trial')
                                        <a href="{{ route('admin.member-trial.index') }}" class="dropdown-item" data-key="t-products">{{trans('system.members.trial')}}</a>
                                    @endcan
                                    @can('show members')
                                        <a href="{{ route('admin.members.index') }}" class="dropdown-item" data-key="t-products">{{trans('system.members.title')}}</a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </li>

                    @can('show collect_part_payments')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="javascript:void(0)" id="topnav-pages" role="button">
                                <i data-feather="gift"></i><span data-key="t-apps">{{ __('system.fields.payment') }}</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-pages">
                                <a href="{{ route('admin.pending.payment') }}" class="dropdown-item" data-key="t-calendar">{{trans('system.fields.pending_payment')}}</a>
                                <a href="{{ route('admin.payment.history') }}" class="dropdown-item" data-key="t-calendar">{{trans('system.fields.payment_history')}}</a>
                            </div>
                        </li>
                    @endcan


                    <!-- Admin menu  -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="javascript:void(0)" id="topnav-pages" role="button">
                            <i data-feather="users"></i><span data-key="t-apps">{{trans('system.fields.admin')}}</span>
                            <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-pages">
                            @can('show branch')
                                <div class="dropdown">
                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="member_add"
                                       role="button">
                                        <span data-key="t-ecommerce">{{ __('system.branch.menu') }}</span>
                                        <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="member_add">
                                        @can('add branch')
                                            <a href="{{ route('admin.branch.create') }}" class="dropdown-item" data-key="t-products">{{trans('system.fields.add')}}</a>
                                        @endcan
                                        <a href="{{ route('admin.branch.index') }}" class="dropdown-item" data-key="t-products">{{trans('system.fields.list')}}</a>
                                    </div>
                                </div>
                            @endcan

                            @can('show staff')
                                <div class="dropdown">
                                    <a class="dropdown-item dropdown-toggle arrow-none" href="javascript:void(0)" id="member_add"
                                       role="button">
                                        <span data-key="t-ecommerce">{{ __('system.staffs.menu') }}</span>
                                        <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="member_add">
                                        @can('add staff')
                                            <a href="{{ route('admin.staffs.create') }}" class="dropdown-item" data-key="t-products">{{trans('system.fields.add')}}</a>
                                        @endcan
                                        <a href="{{ route('admin.staffs.index') }}" class="dropdown-item" data-key="t-products">{{trans('system.fields.list')}}</a>
                                    </div>
                                </div>
                            @endcan
                        </div>
                    </li>


                    @can('show packages')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="javascript:void(0)" id="topnav-pages" role="button">
                                <i data-feather="gift"></i><span data-key="t-apps">{{ __('system.packages.menu') }}</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-pages">
                                @can('add packages')
                                    <a href="{{ route('admin.packages.create') }}" class="dropdown-item" data-key="t-calendar">{{trans('system.fields.add')}}</a>
                                @endcan
                                <a href="{{ route('admin.packages.index') }}" class="dropdown-item" data-key="t-calendar">{{trans('system.fields.list')}}</a>
                            </div>
                        </li>
                    @endcan

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="{{ route('admin.expenses.index') }}" id="topnav-dashboard" role="button">
                            <i data-feather="credit-card"></i><span data-key="t-dashboard">{{ __('system.expenses.menu') }}</span>
                        </a>
                    </li>

                    @can('add sales_report')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="javascript:void(0)" id="topnav-pages" role="button">
                                <i data-feather="pie-chart"></i><span data-key="t-apps">{{ __('system.reports.menu') }}</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-pages">
                                @can('show sales_report')
                                    <a href="{{ route('admin.sales.report') }}" class="dropdown-item" data-key="t-calendar">{{trans('system.reports.sales_report')}}</a>
                                @endcan
                                @can('show expiry_report')
                                    <a href="{{ route('admin.expiry.report') }}" class="dropdown-item" data-key="t-calendar">{{trans('system.reports.expiry_report')}}</a>
                                @endcan
                                @can('show collection_report')
                                    <a href="{{ route('admin.collection.report') }}" class="dropdown-item" data-key="t-calendar">{{trans('system.reports.collection_report')}}</a>
                                @endcan
                                @can('show balance_report')
                                    <a href="{{ route('admin.balance.report') }}" class="dropdown-item" data-key="t-calendar">{{trans('system.reports.balance_report')}}</a>
                                @endcan
                                @can('show attendance_report')
                                    <a href="{{ route('admin.attendance.report') }}" class="dropdown-item" data-key="t-calendar">{{trans('system.reports.attendance_report')}}</a>
                                @endcan
                                @can('show pending_payments')
                                    <a href="{{ route('admin.pending.report') }}" class="dropdown-item" data-key="t-calendar">{{trans('system.reports.pending_payments_report')}}</a>
                                @endcan
                            </div>
                        </li>
                    @endcan

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="{{ route('admin.attendance') }}" role="button">
                            <i data-feather="calendar"></i><span data-key="t-horizontal">{{trans('system.members.attendance')}}</span>
                        </a>
                    </li>

                    @can('add members')
                        <li class="nav-item dropdown">
                            <a class="btn btn-outline-primary mt-2" href="{{ route('admin.members.create') }}" role="button">
                                {{trans('system.fields.add')}} {{trans('system.members.title')}}</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        </nav>
    </div>
</div>
