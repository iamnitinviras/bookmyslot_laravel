(function ($) {
    "use strict";



    $(document).on('change', '.search_feedback_data', function () {
        $("#search_feedback").trigger('submit');
    });

    $(document).on('keypress', '.start_no_space', function (e) {
        if (e.which == 32) {
            return false;
        }
    });
    $(document).on('click', '[data-delete]', function () {
        var ele_sele = $(this).data('delete')
        $(document).find(ele_sele).trigger('submit');
    });
    $(document).on('change', '.my-preview', function () {
        previewSelectedFile(this);
    });
    $('.isUnlimited').on('click', function () {
        let setter = false;
        if ($(this).is(':checked')) {
            setter = true;
        }
        $($(this).data('target')).attr('readonly', setter);
    });

    $('.isUnlimited:checked').each(function (key, element) {
        $($(element).data('target')).attr('readonly', true);
    });
})(jQuery);

function assign_agent_to_ticket($element){
    "use strict";
    const agentid = $($element).data('agentid');
    const ticket = $($element).data('ticket');
    $("#assign_agent_"+ticket+'_'+agentid).trigger('submit');
}
function updateCommentApprovalStatus($element) {
    const id = $($element).data('id');
    $("#update_feedback_comment_"+id).trigger('submit');
}
function previewSelectedFile(input) {
    "use strict";
    var previewattr = $(input).data('preview');
    var preview = $(document).find(previewattr)
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            preview.attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
        preview.show();
        $(document).find(previewattr + "-default").hide();
    }
}

function check_permission($element) {
    "use strict";
    var checked = $($element).prop('checked');
    var value = $($element).val();

    if (checked) {
        if (value == "add members" || value == "edit members" || value == "delete members") {
            $('#members_show').prop('checked', true);
        }

        if (value == "add categories" || value == "edit categories" || value == "delete categories") {
            $('#categories_show').prop('checked', true);
        }

        if (value == "add product_faqs" || value == "edit product_faqs" || value == "delete product_faqs") {
            $('#product_faqs_show').prop('checked', true);
        }

        if (value == "add staff" || value == "edit staff" || value == "delete staff") {
            $('#staff_show').prop('checked', true);
        }
    } else {
        if (value == "show members") {
            $('#members_add').prop('checked', false);
            $('#members_edit').prop('checked', false);
            $('#members_delete').prop('checked', false);
        }

        if (value == "show categories") {
            $('#categories_add').prop('checked', false);
            $('#categories_edit').prop('checked', false);
            $('#categories_delete').prop('checked', false);
        }

        if (value == "show product_faqs") {
            $('#product_faqs_add').prop('checked', false);
            $('#product_faqs_edit').prop('checked', false);
            $('#product_faqs_delete').prop('checked', false);
        }

        if (value == "show staff") {
            $('#staff_add').prop('checked', false);
            $('#staff_edit').prop('checked', false);
            $('#staff_delete').prop('checked', false);
        }
    }


}

function show_payment_section($element) {
    "use strict";
    $("#offline_payment_section").addClass("d-none");
    $("#stripe_payment_section").addClass("d-none");
    $("#paypal_payment_section").addClass("d-none");
    $("#paytm_payment_section").addClass("d-none");

    let value = $($element).val();

    if (value == "offline") {

        $("#reference").attr('required', true);
        $("#offline_payment_section").removeClass("d-none");

    } else if (value == "paypal") {

        $("#paypal_payment_section").removeClass("d-none");

    } else if (value == "stripe") {

        $("#stripe_payment_section").removeClass("d-none");

    } else if (value == "paytm") {

        $("#paytm_payment_section").removeClass("d-none");

    }
}

function is_default_img($this) {
    "use strict";
    let element = $($this);
    var hide_section = $(element.data("section"));
    var input = $(element.data("input"));
    var image_exist = $($this).data("imageexist");

    if (element.is(':checked')) {
        input.prop('required', false);
        hide_section.addClass('d-none');
    } else {
        if (image_exist == 0) {
            input.prop('required', true);
        }
        hide_section.removeClass('d-none');
    }
}

function createSlug($this) {
    var title = $($this).val();
    if (title != "") {
        var slug = title.toLowerCase().trim().replace(/ /g, '-').replace(/[-]+/g, '-').replace(/[^\w-]+/g, '');
        $("#input-board_slug").val(slug);
    }
}

function show_rightbar_section($element) {
    "use strict";
    let id = $($element).data('id');
    let url = $($element).data('url');
    let action = $($element).data('action');

    $.ajax({
        type: 'GET',
        url: url,
        data: {
            id: id,
            action: action
        },
        success: function (data) {
            if (data != "") {
                $("#system_right_bar_content").html(data);
                $("body").toggleClass("right-bar-enabled");
            }
        }
    });
}

function get_package_details($element) {
    "use strict";
    let id = $($element).val();
    let url = $($element).data('url');
    $.ajax({
        type: 'GET',
        url: url,
        data: {
            id: id,
        },
        success: function (data) {
           $("#package_price").val(data.price);
           $("#package_end_date").val(data.package_end_date);
           let payment_type=$("#payment_type").val();
            $("#amount_paid").val(data.price);
            $("#amount_pending").val('');
            calculate_discount();
        }
    });
}

function get_paid_amount_validation($element){
    let value = $($element).val();
    $("#amount_paid").removeAttr('min');
    $("#amount_paid").removeAttr('max');

    $("#amount_paid").val('');
    $("#discount").val('');
    $("#amount_pending").val('');

    const totalAmount = parseFloat($('#package_price').val());
    const amountPaid = parseFloat($("#amount_paid").val());
    const discount = parseFloat($('#discount').val());

    let packagePrice = totalAmount-(isNaN(discount) ? 0 : discount);

    if (value=='full'){
        $(".amount_pending_section").addClass('d-none');

        $("#amount_paid").val(packagePrice);
        $("#amount_paid").attr('min',packagePrice);
        $("#amount_paid").attr('max',packagePrice);
        $("#amount_pending").val(0);
    }

    if (value=='partial'){
        $(".amount_pending_section").removeClass('d-none');
        $("#amount_paid").removeAttr('min');
        $("#amount_paid").attr('max',packagePrice);
    }
}

function closeSidebar() {
    "use strict";
    $("body").removeClass("right-bar-enabled");
}

function calculate_pending_amount(){
    // Get the total amount and amount paid
    const totalAmount = parseFloat($('#package_price').val());
    const amountPaid = parseFloat($("#amount_paid").val());
    const discount = parseFloat($('#discount').val());

    // Calculate the pending amount
    let pendingAmount = totalAmount - (isNaN(amountPaid) ? 0 : amountPaid)-(isNaN(discount) ? 0 : discount);

    // Ensure pending amount is not negative
    pendingAmount = pendingAmount < 0 ? 0 : pendingAmount;

    // Update the pending amount field
    $('#amount_pending').val(pendingAmount);
}

function calculate_discount() {
    // Get the total amount and amount paid
    const discount = parseFloat($('#discount').val());
    const totalAmount = parseFloat($('#package_price').val());

    // Calculate the pending amount
    let amount = totalAmount - discount;

    $("#amount_paid").val(amount);
    $("#amount_paid").attr('min',amount);
    $("#amount_paid").attr('max',amount);

    let payment_type=$("#payment_type").val();
    if (payment_type=='partial'){
        $("#amount_paid").removeAttr('min');
    }
}

function adminLogout() {
    "use strict";
    $("#admin-logout-form").trigger('submit');
}
function updateRoadmapStatus($element) {
    "use strict";
    const id = $($element).data('id');
    $("#update_feedback_roadmap_" + id).trigger('submit');
}

function updateApprovalStatus($element) {
    "use strict";
    const id = $($element).data('id');
    $("#update_feedback_approval_status_" + id).trigger('submit');
}

function changeDefaultBoard($element){
    "use strict";
    const id = $($element).data('id');
    $("#default_board_" + id).trigger('submit');
}
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
function recaptcha_enable($element) {
    "use strict";
    const value = $($element).val();
    if (value == 1) {
        $("#enable_captcha_section").removeClass('d-none');
        $("#nocaptcha_secret").attr('required', true);
        $("#nocaptcha_sitekey").attr('required', true);
    } else {
        $("#enable_captcha_section").addClass('d-none');
        $("#nocaptcha_secret").attr('required', false);
        $("#nocaptcha_sitekey").attr('required', false);
    }
}
