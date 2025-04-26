@extends('layouts.app')
@section('title', __('system.plans.menu'))
@push('page_css')
    <style>
        #loader {
            display: none;
            position: fixed;
            z-index: 9999;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(3px);
            justify-content: center;
            align-items: center;
        }

        .loader-icon {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3498db;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

@section('content')
    <div id="loader">
        <div class="loader-icon"></div>
    </div>
@endsection
@if (isset($subscription_id) && $subscription_id != null)

@endif
@push('page_scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        document.getElementById('loader').style.display = 'flex'; // Show loader
        let id = '{{ $id }}';
        const BASE_URL = "{{ url('/') }}";

        var options = {
            key: '{{ config('razorpay.key_id') }}',
            subscription_id: '{{ $subscription_id }}',
            name: '{{ config('app.name') }}',
            // description: "Monthly Plan",
            handler: function (response) {
                document.getElementById('loader').style.display = 'none';
                window.location.href = BASE_URL + "/razor-pay/success?payment_id=" + response.razorpay_payment_id + "&subscription_id=" + response.razorpay_subscription_id + "&id=" + id;
            },
            theme: {
                color: "#3399cc"
            }
        };
        try {
            var rzp = new Razorpay(options);

            rzp.open();
        }
        catch (err) {
            alert("asd")
        }
    </script>
@endpush
