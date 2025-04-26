<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    let id = '{{ $id }}';
    const BASE_URL = "{{ url('/') }}";

    var options = {
        key: '{{ config('razorpay.key_id') }}',
        subscription_id: '{{ $subscription_id }}',
        name: '{{ config('app.name') }}',
        // description: "Monthly Plan",
        handler: function (response) {
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
