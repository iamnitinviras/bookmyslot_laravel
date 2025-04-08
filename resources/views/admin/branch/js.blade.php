<script>
    (function($) {
        "use strict";
        var request

        function GetQR(save = 0) {
            if (request) {
                request.abort();
            }
            var data = $('#QRData')[0];
            data = new FormData(data);
            var types = ['application/octet-stream', 'image/gif', 'image/png', 'image/jpeg'];
            var f_type = data.get('image').type;
            if (!types.includes(f_type)) {
                if (f_type != "")
                    alertify.error('{{ __('validation.allow_only_jpg_png_gif_error') }}');
                data.delete('image');
                $('#profile_image').val('');
                $(".preview-image").addClass('d-none');
                $(".remove-logo").remove();
            }

            request = $.ajax({
                    url: '{{ route('admin.genarteQR', ['product' => $product->id]) }}?save=' + save,
                    type: 'post',
                    data: data,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $("#loader").show();
                        $("#QRDisplay").addClass('d-none');
                    },
                    success: function (responce) {
                        if (save) {
                            document.location.reload();
                            return;
                        }
                        $("#loader").hide();
                        $("#QRDisplay").removeClass('d-none');
                        $('#QRDisplay').html(responce);
                    }
                }
            )
        }

        $(document).on('submit', '#QRData', function (e) {
            e.preventDefault();
            GetQR(1);
        })

        $(document).on('change', '.qr-genarte', function () {
            if ($(this).attr('name') == "gradient_method") {
                if ($(this).val() == "") {
                    $('.one-colors-div').show()
                    $('.gradient-colors-div').hide()
                } else {
                    $('.one-colors-div').hide()
                    $('.gradient-colors-div').show()
                }
            }
            GetQR();
        });

        $(document).on('click', '.reset', function () {
            $('#QRData').trigger("reset")
            setTimeout(GetQR(), 200);
        })
        $(document).on('click', '.remove-image', function () {
            var data = $('#QRData')[0];
            data = new FormData(data);
            data.delete('image');
            $('#profile_image').val('');
            $(".preview-image").addClass('d-none')
            $(".remove-logo").remove();
            GetQR();
        });

        $(document).find('[name=gradient_method]').change();
        $(document).on('click', '.dwn-png', function () {
            var img =  $(document).find('.section-to-print')
            var width = img.width()
            var height = img.height()
            svgString2Image($(this).data('href'), width, height, 'png', /* callback that gets png data URL passed to it */function (pngData) {
                var a = document.createElement("a"); //Create <a>
                a.href = pngData; //Image Base64 Goes here
                a.download = "{{ $product->title }}.png"; //File name Here
                a.click();
            });
        });
        function svgString2Image(svgString, width, height, format, callback) {
            // set default for format parameter
            format = format ? format : 'png';
            // SVG data URL from SVG string
            var svgData = svgString;
            // create canvas in memory(not in DOM)
            var canvas = document.createElement('canvas');
            // get canvas context for drawing on canvas
            var context = canvas.getContext('2d');
            // set canvas size
            canvas.width = width;
            canvas.height = height;
            // create image in memory(not in DOM)
            var image = new Image();
            // later when image loads run this
            image.onload = function () { // async (happens later)
                // clear canvas
                context.clearRect(0, 0, width, height);
                // draw image with SVG data to canvas
                context.drawImage(image, 0, 0, width, height);
                // snapshot canvas as png
                var pngData = canvas.toDataURL('image/' + format);
                // pass png data URL to callback
                callback(pngData);
            }; // end async
            // start loading SVG data into in memory image
            image.src = svgData;
        }
    })(jQuery);
</script>
