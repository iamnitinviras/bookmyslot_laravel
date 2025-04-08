@extends('landing_page.app')
@section('title',trans('system.faq.menu'))
@section('content')
    <!-- Breadcrumb Area-->
    <div class="breadcrumb-wrapper bg-img bg-overlay" style="background-image: url('{{asset('front-images/breadcum.png')}}');">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcrumb-content">
                        <h2 class="breadcrumb-title">{{trans('system.faq.menu')}}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">{{trans('system.frontend.home')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{trans('system.faq.menu')}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-120 d-block"></div>
    <!-- FAQ Area-->
    <div class="faq--area">
        <div class="container">
            <div class="row g-4 g-lg-5">

                <div class="col-12 col-lg-12">
                    <div class="faq-content">
                        <div class="accordion faq--accordian" id="faqaccordian">

                            @if(isset($faqs) && count($faqs)>0)
                                @foreach($faqs as $key=> $faq)
                                    <div class="card border-0 mb-3">
                                        <div class="card-header" id="headingOne{{$faq->id}}">
                                            <button class="btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{$faq->id}}" aria-expanded="true" aria-controls="collapseOne{{$faq->id}}">{{$faq->question}}</button>
                                        </div>
                                        <div class="collapse @if($key==0) show @endif " id="collapseOne{{$faq->id}}" aria-labelledby="headingOne{{$faq->id}}" data-bs-parent="#faqaccordian">
                                            <div class="card-body">
                                                <p>{!! nl2br($faq->answer) !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-120 d-block"></div>
@endsection
