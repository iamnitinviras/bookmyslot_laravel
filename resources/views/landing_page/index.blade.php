@extends('landing_page.app')
@section('title', config('app.name'))
@section('content')
    <!-- Welcome Area -->
    <div class="welcome-area bg-gradient">
        <!-- Background Shape -->
        <div class="background-shape">
            <div class="circle1 wow fadeInRightBig" data-wow-duration="4000ms"></div>
            <div class="circle2 wow fadeInRightBig" data-wow-duration="4000ms"></div>
            <div class="circle3 wow fadeInRightBig" data-wow-duration="4000ms"></div>
            <div class="circle4 wow fadeInRightBig" data-wow-duration="4000ms"></div>
        </div>
        <!-- Background Animation -->
        <div class="background-animation">
            <div class="item1"></div>
            <div class="item2"></div>
            <div class="item3"></div>
            <div class="item4"></div>
            <div class="item5"></div>
        </div>
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-between">
                <!-- Welcome Content -->
                <div class="col-12 col-sm-10 col-md-6">
                    <div class="welcome-content">
                        <h2 class="wow fadeInUp" data-wow-duration="1s" data-wow-delay="300ms">{{ __('system.frontend.better_feedback') }} <br> {{ __('system.frontend.better_product') }}.</h2>
                        <p class="mb-4 wow fadeInUp" data-wow-duration="1s" data-wow-delay="400ms">{{ __('system.frontend.collect_feedback') }}</p>
                    </div>
                </div>
                <!-- Welcome, Thumb -->
                <div class="col-12 col-sm-9 col-md-6">
                    <div class="welcome-thumb ms-xl-5 wow fadeInUp" data-wow-duration="1s" data-wow-delay="1s"><img src="{{ asset(config('custom.banner_image_one')) }}" alt=""></div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-120 d-block"></div>

    <!-- Service Area-->
    <div class="service-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-9 col-lg-8">
                    <div class="section-heading text-center">
                        <h2>{{trans('system.how_it_works.how_it_works_main_title')}}</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center g-4 g-xl-5">
                <!-- Single Service -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card service-card wow fadeInUp" data-wow-delay="100ms" data-wow-duration="1000ms">
                        <div class="card-body p-0 px-lg-0">
                            <div class="icon"><i class="bi bi-app-indicator"></i></div>
                            <h5>{{trans('system.how_it_works.how_it_works_title_one')}}</h5>
                            <p>{{trans('system.how_it_works.how_it_works_description_one')}}</p>
                        </div>
                    </div>
                </div>
                <!-- Single Service -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card service-card wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1000ms">
                        <div class="card-body p-0 px-lg-0">
                            <div class="icon"><i class="bi bi-columns"></i></div>
                            <h5>{{trans('system.how_it_works.how_it_works_title_two')}}</h5>
                            <p>{{trans('system.how_it_works.how_it_works_description_two')}}</p>
                        </div>
                    </div>
                </div>
                <!-- Single Service -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card service-card wow fadeInUp" data-wow-delay="300ms" data-wow-duration="1000ms">
                        <div class="card-body p-0 px-lg-0">
                            <div class="icon"><i class="bi bi-pie-chart"></i></div>
                            <h5>{{trans('system.how_it_works.how_it_works_title_three')}}</h5>
                            <p>{{trans('system.how_it_works.how_it_works_description_three')}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-120 d-block"></div>
    <!-- Features Area -->
    <div class="feature-area bg-primary pt-120 pb-120">
        <!-- Background Shape -->
        <div class="background-shape wow fadeInLeftBig" data-wow-duration="4000ms"></div>
        <!-- Curve Top Shape-->
        <div class="curve-shape-top"></div>
        <!-- Curve Bottom Shape-->
        <div class="curve-shape-bottom"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-9 col-lg-8">
                    <div class="section-heading text-center white">
                        <h2>{{trans('system.advantages.advantages_main_title')}}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row g-4 justify-content-center">
                <!-- Single Feature Area -->
                <div class="col-12 col-sm-10 col-md-6 col-lg-6">
                    <div class="card feature-card">
                        <div class="card-body advantage_card d-flex align-items-center"><i class="bg-primary bi bi-tools"></i>
                            <div class="fea-text">
                                <h6>{{trans('system.advantages.advantages_title_one')}}</h6>
                                <span>{{trans('system.advantages.advantages_description_one')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Single Feature Area -->
                <div class="col-12 col-sm-10 col-md-6 col-lg-6">
                    <div class="card feature-card">
                        <div class="card-body advantage_card d-flex align-items-center"><i class="bg-success bi bi-brush"></i>
                            <div class="fea-text">
                                <h6>{{trans('system.advantages.advantages_title_two')}}</h6>
                                <span>{{trans('system.advantages.advantages_description_two')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Single Feature Area -->

                <!-- Single Feature Area -->
                <div class="col-12 col-sm-10 col-md-6 col-lg-6">
                    <div class="card feature-card">
                        <div class="card-body advantage_card d-flex align-items-center"><i class="bg-danger bi bi-twitter"></i>
                            <div class="fea-text">
                                <h6>{{trans('system.advantages.advantages_title_three')}}</h6>
                                <span>{{trans('system.advantages.advantages_description_three')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Single Feature Area -->

                <!-- Single Feature Area -->
                <div class="col-12 col-sm-10 col-md-6 col-lg-6">
                    <div class="card feature-card">
                        <div class="card-body advantage_card d-flex align-items-center"><i class="bg-success bi bi-bug"></i>
                            <div class="fea-text">
                                <h6>{{trans('system.advantages.advantages_title_four')}}</h6>
                                <span>{{trans('system.advantages.advantages_description_four')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-120 d-block"></div>
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
                                            <h2 class="mb-0 monthly-price">{{config('custom.trial_days')}}<span class="fz-12">{{trans('system.plans.days')}}</span></h2>
                                        </div>
                                    </div>
                                    <div class="price-icon"><img src="{{asset('landing_page/img/svg-icon/plant2.svg')}}" alt=""></div>
                                </div>
                                <div class="pricing-desc mb-5">
                                    <ul class="list-unstyled mb-0">
                                        <li><font
                                                style="vertical-align: inherit;"><strong>{{config('custom.trial_board')}}</strong> {{trans('system.plans.branch_limit')}}
                                            </font></li>
                                        <li><font
                                                style="vertical-align: inherit;"><strong>{{config('custom.trial_staff')}}</strong> {{trans('system.plans.staff_limit')}}
                                            </font></li>
                                        <li><font
                                                style="vertical-align: inherit;">{{trans('system.plans.unlimited_support')}}</font>
                                        </li>
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
                                                    @if($plan->unlimited_branch=='yes')
                                                        <li><font
                                                                style="vertical-align: inherit;">{{trans('system.plans.unlimited_branch')}}</font>
                                                        </li>
                                                    @else
                                                        <li><font
                                                                style="vertical-align: inherit;"><strong>{{$plan->branch_limit}}</strong> {{trans('system.plans.branch_limit')}}
                                                            </font></li>
                                                    @endif


                                                    @if($plan->staff_unlimited=='yes')
                                                        <li><font
                                                                style="vertical-align: inherit;">{{trans('system.plans.unlimited_staff')}}</font>
                                                        </li>
                                                    @else
                                                        <li><font
                                                                style="vertical-align: inherit;"><strong>{{$plan->staff_limit}}</strong> {{trans('system.plans.staff_limit')}}
                                                            </font></li>
                                                    @endif

                                                    <li><font
                                                            style="vertical-align: inherit;">{{trans('system.plans.unlimited_support')}}</font>
                                                    </li>
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
                                                    @if($plan->unlimited_branch=='yes')
                                                        <li><font
                                                                style="vertical-align: inherit;">{{trans('system.plans.unlimited_branch')}}</font>
                                                        </li>
                                                    @else
                                                        <li><font
                                                                style="vertical-align: inherit;"><strong>{{$plan->branch_limit}}</strong> {{trans('system.plans.branch_limit')}}
                                                            </font></li>
                                                    @endif


                                                    @if($plan->staff_unlimited=='yes')
                                                        <li><font
                                                                style="vertical-align: inherit;">{{trans('system.plans.unlimited_staff')}}</font>
                                                        </li>
                                                    @else
                                                        <li><font
                                                                style="vertical-align: inherit;"><strong>{{$plan->staff_limit}}</strong> {{trans('system.plans.staff_limit')}}
                                                            </font></li>
                                                    @endif

                                                    <li><font
                                                            style="vertical-align: inherit;">{{trans('system.plans.unlimited_support')}}</font>
                                                    </li>
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
@section('custom-js')
    <script>
        $('#contactForm').validate({
            errorPlacement: function(error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            highlight: function(element) {
                $(element).addClass("error");
            },
            unhighlight: function(element) {
                $(element).removeClass("error");
            }
        });
    </script>
@endsection
