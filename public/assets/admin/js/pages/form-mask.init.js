document.addEventListener("DOMContentLoaded", function () {

    if ($("#price-mask").length > 0) {
        var currencyMask = IMask(document.getElementById("price-mask"), {
            mask: [
                { mask: "" },
                {
                    mask: "num",
                    lazy: false,
                    blocks: {
                        num: {
                            mask: Number,
                            scale: 2,
                            padFractionalZeros: true,
                            radix: ".",
                            mapToRadix: ["."],
                        },
                    },
                },
            ],
        });
    }
});
