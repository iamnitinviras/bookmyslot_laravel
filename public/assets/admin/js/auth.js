(function($) {
    "use strict";
    $("#resend-email-verification-link").on('click',function (e){
        $("#auth-resend-form").trigger('submit');
    });

    $("#auth-logout-form-button").on('click',function (e){
       $("#auth-logout-form").trigger('submit');
    });
})(jQuery);
