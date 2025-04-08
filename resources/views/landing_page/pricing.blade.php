@extends('landing_page.app')
@section('title',trans('system.plans.pricing'))
@section('content')
    <!-- Breadcrumb Area-->
    <div class="breadcrumb-wrapper bg-img bg-overlay" style="background-image: url('{{asset('front-images/breadcum.png')}}');">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcrumb-content">
                        <h2 class="breadcrumb-title">{{trans('system.plans.pricing')}}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">{{trans('system.frontend.home')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{trans('system.plans.pricing')}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pricing Plan Area -->
    <div class="saasbox-pricing-plan-area bg-gray pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-9 col-lg-7">
                    <div class="section-heading text-center">
                        <h6>{{trans('system.plans.pricing_plan')}}</h6>
                        <h2>{{trans('system.plans.plan_frontend_title')}}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="row g-0 justify-content-center">
                        <!-- Single Pricing Plan-->
                        <div class="col-12 col-sm-9 col-md-7 col-lg-4">
                            <div class="card pricing-card monthly-plan mb-30 wow fadeInLeft" data-wow-duration="1000ms">
                                <div class="pricing-heading d-flex justify-content-between mb-5">
                                    <div class="price"><span class="badge bg-primary rounded-3 fz-12">{{trans('system.plans.trial')}}</span>
                                        <div class="price-quantity">
                                            <h2 class="mb-0 monthly-price">{{config('app.trial_days')}}<span class="fz-12">{{trans('system.plans.days')}}</span></h2>
                                        </div>
                                    </div>
                                    <div class="price-icon"><img src="{{asset('landing_page/img/svg-icon/plant2.svg')}}" alt=""></div>
                                </div>
                                <div class="pricing-desc mb-5">
                                    <ul class="list-unstyled mb-0">
                                        <li><font style="vertical-align: inherit;"><strong>{{config('app.trial_board')}}</strong> {{trans('system.plans.branch_limit')}}</font></li>
                                        <li><font style="vertical-align: inherit;"><strong>{{config('app.trial_staff')}}</strong> {{trans('system.plans.staff_limit')}} </font></li>
                                        <li><font style="vertical-align: inherit;">{{trans('system.plans.unlimited_support')}}</font></li>
                                        <br/>
                                    </ul>
                                </div>
                                <div class="pricing-btn"><a class="btn btn-primary" href="{{url('/register')}}">{{ __('auth.register') }}</a></div>
                            </div>
                        </div>
                        @if(isset($plans) && count($plans)>0)
                            @foreach($plans as $key=> $plan)
                                <div class="col-12 col-sm-9 col-md-7 col-lg-4">
                                    @if($key==0)
                                        <div class="card pricing-card monthly-plan active mb-30">

                                            <div class="pricing-heading d-flex justify-content-between mb-5">
                                                <div class="price"><span class="badge bg-warning rounded-3 fz-12">{{$plan->local_title}}</span>
                                                    <div class="price-quantity">
                                                        <h2 class="mb-0 monthly-price">{{displayCurrency($plan->amount)}}<span class="fz-12">{{trans('system.plans.' . $plan->type)}}</span></h2>
                                                    </div>
                                                </div>
                                                <div class="price-icon"><img src="{{asset('landing_page/img/svg-icon/plant.svg')}}" alt=""></div>
                                            </div>

                                            <div class="pricing-desc mb-5">
                                                <ul class="list-unstyled mb-0">
                                                    @if($plan->branch_unlimited=='yes')
                                                        <li><font style="vertical-align: inherit;">{{trans('system.plans.unlimited_board')}}</font></li>
                                                    @else
                                                        <li><font style="vertical-align: inherit;"><strong>{{$plan->branch_limit}}</strong> {{trans('system.plans.branch_limit')}}</font></li>
                                                    @endif

                                                    @if($plan->staff_unlimited=='yes')
                                                        <li><font style="vertical-align: inherit;">{{trans('system.plans.unlimited_staff')}}</font></li>
                                                    @else
                                                        <li><font style="vertical-align: inherit;"><strong>{{$plan->staff_limit}}</strong> {{trans('system.plans.staff_limit')}}</font></li>
                                                    @endif

                                                    <li><font style="vertical-align: inherit;">{{trans('system.plans.unlimited_support')}}</font></li>
                                                </ul>
                                            </div>
                                            <div class="pricing-btn"><a class="btn btn-warning" href="{{url('/register')}}">{{ __('auth.register') }}</a></div>
                                        </div>
                                    @else
                                        <div class="card pricing-card monthly-plan mb-30 wow fadeInRight" data-wow-duration="1000ms">
                                            <div class="pricing-heading d-flex justify-content-between mb-5">
                                                <div class="price"><span class="badge bg-info rounded-3 fz-12">{{$plan->local_title}}</span>
                                                    <div class="price-quantity">
                                                        <h2 class="mb-0 monthly-price">{{displayCurrency($plan->amount)}}<span class="fz-12">{{trans('system.plans.' . $plan->type)}}</span></h2>
                                                    </div>
                                                </div>
                                                <div class="price-icon"><img src="{{asset('landing_page/img/svg-icon/saving-money.svg')}}" alt=""></div>
                                            </div>
                                            <div class="pricing-desc mb-5">
                                                <ul class="list-unstyled mb-0">
                                                    @if($plan->branch_unlimited=='yes')
                                                        <li><font style="vertical-align: inherit;">{{trans('system.plans.unlimited_board')}}</font></li>
                                                    @else
                                                        <li><font style="vertical-align: inherit;"><strong>{{$plan->branch_limit}}</strong> {{trans('system.plans.branch_limit')}}</font></li>
                                                    @endif

                                                    @if($plan->staff_unlimited=='yes')
                                                        <li><font style="vertical-align: inherit;">{{trans('system.plans.unlimited_staff')}}</font></li>
                                                    @else
                                                        <li><font style="vertical-align: inherit;"><strong>{{$plan->staff_limit}}</strong> {{trans('system.plans.staff_limit')}}</font></li>
                                                    @endif

                                                    <li><font style="vertical-align: inherit;">{{trans('system.plans.unlimited_support')}}</font></li>
                                                </ul>
                                            </div>
                                            <div class="pricing-btn"><a class="btn btn-info" href="{{url('/register')}}">{{ __('auth.register') }}</a></div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-120 d-block"></div>
@endsection
