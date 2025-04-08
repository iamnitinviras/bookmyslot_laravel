window.onload = function () {
    var validEle = document.getElementById("pristine-valid");
    var validClassEle = document.getElementsByClassName("custom_form_validation");
    if (validEle != undefined) {
        $(document).on('submit', '#pristine-valid', function (e) {
            var t = new Pristine(validEle);
            if (!t.validate()) {
                e.preventDefault();
                $('.has-danger:first .form-control').focus();
            } else {
                $(document).find('body').css('pointer-events', 'none');
                $(document).find('body').css('overflow', 'hidden');
                $(document).find('.pace').toggleClass('pace-active pace-inactive');
            }
        });
    }

    if (validClassEle != undefined) {
        $(document).on('submit', '.custom_form_validation', function (e) {
            var ct = new Pristine(validClassEle);
            if (!ct.validate()) {
                e.preventDefault();
                $('.has-danger:first .form-control').focus();
            } else {
                $(document).find('body').css('pointer-events', 'none');
                $(document).find('body').css('overflow', 'hidden');
                $(document).find('.pace').toggleClass('pace-active pace-inactive');
            }
        });
    }

};

function NumberValidate(e) {
    var keyCode = e.keyCode || e.which;
    var regex = /^[0-9]+$/;
    var isValid = regex.test(String.fromCharCode(keyCode));
    return isValid;
}
