!(function (n) {
    "use strict";
    var xhttp = new XMLHttpRequest();
    var e,
        t,
        a,
        o = localStorage.getItem("data-layout-mode"),
        r = "en";

    function d(t) {
        document.body.setAttribute("data-layout-mode", localStorage.getItem("data-layout-mode"))
    }

    function i() {
        var t = document.querySelectorAll(".counter-value");
        t.forEach(function (o) {
            !(function t() {
                var e = +o.getAttribute("data-target"),
                    a = +o.innerText,
                    n = e / 250;
                n < 1 && (n = 1),
                    a < e
                        ? ((o.innerText = (a + n).toFixed(0)), setTimeout(t, 1))
                        : (o.innerText = e);
            })();
        });
    }

    function s() {
        for (
            var t = document
                    .getElementById("topnav-menu-content")
                    .getElementsByTagName("a"),
                e = 0,
                a = t.length;
            e < a;
            e++
        )
            t[e] &&
            t[e].parentElement &&
            "nav-item dropdown active" ===
            t[e].parentElement.getAttribute("class") &&
            (t[e].parentElement.classList.remove("active"),
            t[e].nextElementSibling &&
            t[e].nextElementSibling.classList.remove("show"));
    }

    function l(t) {
        null !== t;
    }

    function c() {
        document.webkitIsFullScreen ||
        document.mozFullScreen ||
        document.msFullscreenElement ||
        n("body").removeClass("fullscreen-enable");
    }

    n("#side-menu").metisMenu(),
        i(),
        (e = document.body.getAttribute("data-sidebar-size")),
        n(window).on("load", function () {
            n(".switch").on("switch-change", function () {
                toggleWeather();
            });
            var t,
                e = document.querySelector("body");
            for (t of e.getAttributeNames()) {
                var a = e.getAttribute(t);
                localStorage.setItem(t, a),
                    document.body.hasAttribute("data-sidebar")
                        ? localStorage.removeItem("data-topbar")
                        : document.body.hasAttribute("data-topbar") &&
                        localStorage.removeItem("data-sidebar");
            }
            //body.hasAttribute(!1) && l("topbar-color-light"),
            1024 <= window.innerWidth &&
            window.innerWidth <= 1366 &&
            (document.body.setAttribute("data-sidebar-size", "sm"),
                l("sidebar-size-small"));
        }),
        n("#vertical-menu-btn").on("click", function (t) {
            t.preventDefault(),
                n("body").toggleClass("sidebar-enable"),
            992 <= n(window).width() &&
            (null == e
                ? null ==
                document.body.getAttribute("data-sidebar-size") ||
                "lg" ==
                document.body.getAttribute("data-sidebar-size")
                    ? document.body.setAttribute(
                        "data-sidebar-size",
                        "sm"
                    )
                    : document.body.setAttribute(
                        "data-sidebar-size",
                        "lg"
                    )
                : "md" == e
                    ? "md" ==
                    document.body.getAttribute("data-sidebar-size")
                        ? document.body.setAttribute(
                            "data-sidebar-size",
                            "sm"
                        )
                        : document.body.setAttribute(
                            "data-sidebar-size",
                            "md"
                        )
                    : "sm" ==
                    document.body.getAttribute("data-sidebar-size")
                        ? document.body.setAttribute("data-sidebar-size", "lg")
                        : document.body.setAttribute(
                            "data-sidebar-size",
                            "sm"
                        ));
        }),
        n("#sidebar-menu a").each(function () {
            var t = window.location.href.split(/[?#]/)[0];
            //  console.log( )
            // this.href == t
            t.search(this.href) > -1 &&
            (n(this).addClass("active"),
                n(this).parent().addClass("mm-active"),
                n(this).parent().parent().addClass("mm-show"),
                n(this).parent().parent().prev().addClass("mm-active"),
                n(this).parent().parent().parent().addClass("mm-active"),
                n(this).parent().parent().parent().parent().addClass("mm-show"),
                n(this)
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .addClass("mm-active"));
        }),
        n(document).ready(function () {
            var t;
            0 < n("#sidebar-menu").length &&
            0 < n("#sidebar-menu .mm-active .active").length &&
            300 <
            (t = n("#sidebar-menu .mm-active .active").offset().top) &&
            ((t -= 300),
                n(".vertical-menu .simplebar-content-wrapper").animate(
                    {scrollTop: t},
                    "slow"
                ));
        }),
        n(".navbar-nav a").each(function () {
            var t = window.location.href.split(/[?#]/)[0];
            this.href == t &&
            (n(this).addClass("active"),
                n(this).parent().addClass("active"),
                n(this).parent().parent().addClass("active"),
                n(this).parent().parent().parent().addClass("active"),
                n(this).parent().parent().parent().parent().addClass("active"),
                n(this)
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .addClass("active"),
                n(this)
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .addClass("active"));
        }),
        n('[data-toggle="fullscreen"]').on("click", function (t) {
            t.preventDefault(),
                n("body").toggleClass("fullscreen-enable"),
                document.fullscreenElement ||
                document.mozFullScreenElement ||
                document.webkitFullscreenElement
                    ? document.cancelFullScreen
                        ? document.cancelFullScreen()
                        : document.mozCancelFullScreen
                            ? document.mozCancelFullScreen()
                            : document.webkitCancelFullScreen &&
                            document.webkitCancelFullScreen()
                    : document.documentElement.requestFullscreen
                        ? document.documentElement.requestFullscreen()
                        : document.documentElement.mozRequestFullScreen
                            ? document.documentElement.mozRequestFullScreen()
                            : document.documentElement.webkitRequestFullscreen &&
                            document.documentElement.webkitRequestFullscreen(
                                Element.ALLOW_KEYBOARD_INPUT
                            );
        }),
        [].slice
            .call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            .map(function (t) {
                return new bootstrap.Tooltip(t);
            }),
        [].slice
            .call(document.querySelectorAll('[data-bs-toggle="popover"]'))
            .map(function (t) {
                return new bootstrap.Popover(t);
            }),
        [].slice.call(document.querySelectorAll(".toast")).map(function (t) {
            return new bootstrap.Toast(t);
        }),
    window.sessionStorage &&
    ((t = sessionStorage.getItem("is_visited"))
        ? n("#" + t).prop("checked", !0)
        : sessionStorage.setItem("is_visited", "layout-ltr")),
        n("#password-addon").on("click", function () {
            0 < n(this).siblings("input").length &&
            ("password" == n(this).siblings("input").attr("type")
                ? n(this).siblings("input").attr("type", "input")
                : n(this).siblings("input").attr("type", "password"));
        }),
    o && "null" != o && o !== r && d(o),
        n(".language").on("click", function (t) {
            d(n(this).attr("data-lang"));
        }),
        feather.replace(),
        n(window).on("load", function () {
            n("#status").fadeOut(), n("#preloader").delay(350).fadeOut("slow");
        }),
        (a = document.getElementsByTagName("body")[0]),
        n("#mode-setting-btn").on("click", function (t) {
            if (document.body.getAttribute("data-layout-mode") === "dark") {
                localStorage.setItem('data-layout-mode', 'light');
                document.body.setAttribute("data-layout-mode", "light");
            } else {
                localStorage.setItem('data-layout-mode', 'dark');
                document.body.setAttribute("data-layout-mode", "dark")
            }
        }),
        a.hasAttribute("data-layout") &&
        "horizontal" == a.getAttribute("data-layout")
            ? (l("layout-horizontal"), n(".sidebar-setting").hide())
            : l("layout-vertical"),
        a.hasAttribute("data-layout-mode") &&
        "dark" == a.getAttribute("data-layout-mode")
            ? l("layout-mode-dark")
            : l("layout-mode-light"),
        a.hasAttribute("data-layout-size") &&
        "boxed" == a.getAttribute("data-layout-size")
            ? l("layout-width-boxed")
            : l("layout-width-fuild"),
        a.hasAttribute("data-layout-scrollable") &&
        "true" == a.getAttribute("data-layout-scrollable")
            ? l("layout-position-scrollable")
            : l("layout-position-fixed"),
        "light" != a.getAttribute("data-topbar") &&
        "dark" == a.getAttribute("data-topbar")
            ? l("topbar-color-dark")
            : l("topbar-color-light"),
        a.hasAttribute("data-sidebar-size") &&
        "sm" == a.getAttribute("data-sidebar-size")
            ? l("sidebar-size-small")
            : a.hasAttribute("data-sidebar-size") &&
            "md" == a.getAttribute("data-sidebar-size")
                ? l("sidebar-size-compact")
                : l("sidebar-size-default"),
        a.hasAttribute("data-sidebar") &&
        "brand" == a.getAttribute("data-sidebar")
            ? l("sidebar-color-brand")
            : a.hasAttribute("data-sidebar") &&
            "dark" == a.getAttribute("data-sidebar")
                ? l("sidebar-color-dark")
                : l("sidebar-color-light"),
        document.getElementsByTagName("html")[0].hasAttribute("dir") &&
        "rtl" == document.getElementsByTagName("html")[0].getAttribute("dir")
            ? l("layout-direction-rtl")
            : l("layout-direction-ltr"),
        Waves.init(),
        n(".table-check .form-check-input").change(function () {
            n(".table-check .form-check-input:checked").length ==
            n(".table-check .form-check-input").length
                ? n("#checkAll").prop("checked", !0)
                : n("#checkAll").prop("checked", !1);
        });
})(jQuery);
