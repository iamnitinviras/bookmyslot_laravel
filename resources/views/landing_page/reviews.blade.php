@extends('landing_page.app')
@section('title',trans('system.fields.reviews'))
@section('content')
    <!-- Breadcrumb Area-->
    <div class="breadcrumb-wrapper bg-img bg-overlay" style="background-image: url('{{asset('front-images/breadcum.png')}}');">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcrumb-content">
                        <h2 class="breadcrumb-title">{{trans('system.fields.reviews')}}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">{{trans('system.frontend.home')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{trans('system.fields.reviews')}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-gray pt-120 pb-120">
        <div class="container">
            <div class="row g-4 saasbox-portfolio-filter">

                @if(isset($testimonials) && count($testimonials)>0)
                    @foreach($testimonials as $testimonial)
                        <div class="col-12 col-sm-6 col-lg-4 portfolio-item">
                            <div class="card feedback-card border-0 p-2 shadow-sm">
                                <div class="card-body p-4 p-md-5">
                                    <div class="client-info d-flex align-items-center">
                                        @if (isset($testimonial) && $testimonial->testimonial_image != null)
                                            <div class="client-thumb rounded-circle me-2 position-relative">
                                                <img class="rounded-circle" src="{{$testimonial->testimonial_image}}" alt="{{$testimonial->name}}">
                                                <span class="rounded-circle"><i class="bi bi-check"></i></span>
                                            </div>
                                        @endif
                                        <div class="client-name">
                                            <h6 class="fz-14 mb-0">{{$testimonial->name}}</h6>
                                        </div>
                                    </div>
                                    <p class="text-dark mb-0 fw-bold mt-2">{{$testimonial->description}}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
