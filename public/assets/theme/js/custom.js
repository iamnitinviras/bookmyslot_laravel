(function () {
    'use strict';


    if (document.getElementById("editor")!=null){
        ClassicEditor.create(document.querySelector("#editor")).catch((error) => {
            console.error(error);
        });
    }

    var supportForm = document.getElementById("support-form-id");
    if (supportForm!=null){
        // create the pristine instance
        var pristine = new Pristine(supportForm);

        supportForm.addEventListener('submit', function (e) {
            e.preventDefault();
            var valid = pristine.validate();
            if (valid){
                $("#support-form-id .spinner-border").removeClass('d-none');
                $("#support-form-id button[type='submit']").prop('disabled', true);
                supportForm.submit();
            }else{
                $("#support-form-id .spinner-border").addClass('d-none');
                $("#support-form-id button[type='submit']").prop('disabled', false);
            }
        });
    }

    jQuery(document).ready(function () {
        let a = localStorage.getItem("isDark");
        if (a === "true") {
            jQuery("html").addClass("dark");
        } else {
        }

        jQuery(".night_mode_div").click(function () {
            console.log("clicked mode change");
            let classStatus = jQuery("html").hasClass("dark");
            localStorage.setItem("isDark", !classStatus);
            if (!classStatus) {
                jQuery("html").removeClass("light");
                jQuery("html").addClass("dark");
            } else {
                jQuery("html").removeClass("dark");
                jQuery("html").addClass("light");
            }
        });

        let b = localStorage.getItem("isDark2");
        if (b === "true") {
            jQuery("html").addClass("light");
        }

        jQuery(".night_mode_div").click(function () {
            let classStatus = jQuery("html").hasClass("light");
            localStorage.setItem("isDark2", classStatus);
            if (classStatus) {
                jQuery("html").removeClass("dark");
                jQuery("html").addClass("light");
            } else {
                jQuery("html").removeClass("light");
                jQuery("html").addClass("dark");
            }
        });
    });
}());


function scrollTomessage(){
    "use strict";
    $("html, body").animate({ scrollTop: $(document).height() }, 1000);
}

function customerTicketSearch(){
    "use strict";
    $("#customer_ticket_search").trigger('submit');
}

function changeDefaultLanguage($lang){
    "use strict";
    $("#user_set_default_language"+$lang).trigger('submit');
}

function upvote($element) {
    "use strict";
    let url=$($element).data('url');
    $.ajax({
        url: url,
        type: 'post',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        processData: false,
        contentType: false,
        success: function (responce) {
            $("#like_count").text(responce.total_likes);
            $("#dilike_count").text(responce.total_dislikes);
            window.location.reload();
        }
    });
}

function downvote($element) {
    "use strict";
    let url=$($element).data('url');
    $.ajax({
        url: url,
        type: 'post',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        processData: false,
        contentType: false,
        success: function (responce) {
            $("#like_count").text(responce.total_likes);
            $("#dilike_count").text(responce.total_dislikes);
            window.location.reload();
        }
    });
}

