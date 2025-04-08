(function($) {
    "use strict";
    $(document).ready(function () {
        $(document).on("click", "#password-addon", function () {
            var passEle = $(this).parent("div").find("input");
            var type = passEle.attr("type");
            passEle.attr(
                "type",
                "password" === type ? (type = "text") : (type = "password")
            );
        });
    });
})(jQuery);
