<script>
    (function($) {
        "use strict";
        $(document).on("click", "body", function (t) {
            0 < $(t.target).closest(".right-bar-toggle, .right-bar").length ||
            $("body").removeClass("right-bar-enabled");
        });
        const body = document.querySelector('body');
        lazyload();
        window.setTimeout(function() {
            $(".success_error_alerts").fadeTo(3000, 0).slideUp(2000, function() {
                $(this).remove();
            });
        }, 8000);

        $(document).on('submit', '.data-confirm', function(e) {
            let that = $(this);
            e.preventDefault();
            alertify.confirm(
                that.data('confirm-message'),
                function() {
                    e.currentTarget.submit();
                },
                function() {
                    alertify.error('{{ __('system.messages.operation_canceled') }}');
                }
            ).set({
                title: that.data('confirm-title')
            }).set({
                labels: {
                    ok: '{{ __('system.crud.confirmed') }}',
                    cancel: '{{ __('system.crud.cancel') }}'
                }
            });
        });
        $(document).on('keypress', '.filter-on-enter', function(e) {
            if (e.which == 13) { //Enter key pressed
                var that = $(this)
                filter('filter', that);
            }
        });
        $(document).on('change', '.filter-on-change', function(e) {

            var that = $(this)

            let name = 'par_page';
            if (that){
                name = that.attr('name');
            }
            filter(name, that);
        });
        $(document).on('click', '.filter-on-click', function(e) {
            var that = $(this)
            let name = that.attr('name');
            filter(name, that);
        });
    })(jQuery);
</script>
<script>
    function filter(key, that) {
        "use strict";
        var url = '{{ request()->url() }}'
        var query = {!! json_encode(request()->query()) !!}

        var
            value = that.val();
        if (value != null) {
            query[key] = value;
        }
        document.location.href = url + "?" + objectToQueryString(query);
    }

    function objectToQueryString(obj) {
        "use strict";
        var str = [];
        for (var p in obj)
            if (obj.hasOwnProperty(p)) {
                if (obj[p])
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
            }
        return str.join("&");
    }
</script>
<script src="{{ asset('assets/admin/js/app.js') }}"></script>
<script src="{{ asset('assets/admin/cdns/intlTelInput.min.js') }}"></script>
<script>
    (function($) {
        "use strict";
        var input = document.querySelector("#pristine-phone-valid");

        let iti;
        if (input) {
            iti = window.intlTelInput(input, {
                initialCountry: "auto",
                separateDialCode: true,
                formatOnDisplay: false,
                hiddenInput: "phone_number",
                geoIpLookup: function(callback) {
                    $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                        var countryCode = (resp && resp.country) ? resp.country : "us";
                        callback(countryCode);
                    });
                },

                utilsScript: "{{ asset('assets/admin/js/utils.js') }}" // just for formatting/placeholders etc
            });
            $(input).on('blur', function() {
                var number = iti.getNumber();
                $(document).find("[name=phone_number]:last-child").val(number);
            });
        }
    })(jQuery);
</script>
