import AOS from "../vendor/aos/js/aos.js";
import "../vendor/jquery/jquery.min.js";
import "../vendor/bootstrap/js/bootstrap.min.js";
import "../vendor/select2/dist/js/select2.full.min.js";
import "../vendor/select2/dist/js/i18n/ru.js";
(function () {
    "use strict";
    var CSRF_TOKEN = $('meta[name="_token"]').attr("content");
    $.ajaxSetup({
        headers: { "X-CSRF-TOKEN": CSRF_TOKEN },
    });
    $(".select2-single").select2({
        language: "ru",
    });
    $(".select2-single").find(".select2-single").addClass("color-white");
    $(".select2-user").select2({
        language: "ru",
        placeholder: 'Введите ФИО',
        ajax: {
            url: '/api/select2/user/public',
            dataType: 'json',
            delay: 2,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        if (item.id !== undefined)
                        {
                            if (item.patronymic === null)
                            {
                                item.patronymic = ''
                            }
                            return {
                                text: item.lastname+ ' '+item.firstname+' '+item.patronymic,
                                id: item.id
                            }
                        }
                    })
                };
            },
            cache: true
        }
    });
    $(".custom-file-input").on("change", function () {
        if ($(this).val() != "")
            $(this)
                .prev()
                .text("Выбрано файлов: " + $(this)[0].files.length);
        else $(this).prev().text("Выберите файлы");
    });
    var loginForm = $(".user");
    loginForm.on("submit", function (e) {
        e.preventDefault();
        var formData = loginForm.serialize();
        $.ajax({
            url: $(this).attr("action"),
            type: "POST",
            cache: false,
            dataType: "json",
            data: formData,
            beforeSend: function () {
                $(loginForm)
                    .find("input, textarea, select, button[type=submit]")
                    .prop("disabled", true);
            },
            error: function (data) {
                $("#errors-list").empty().hide();
                    $("#errors-list")
                        .append(
                            "<div class='alert alert-danger'>Ошибка сервера. Обратитесь к администратору. Наименование ошибки:" +
                                data.responseJSON.message +
                                "</div>"
                        )
                        .slideDown(700);
                $(loginForm)
                    .find("input, textarea, select, button[type=submit]")
                    .prop("disabled", false);
            },
            success: function (data) {
                window.location.href = data.intended;
            },
        });
    });

    $(".form-submit").each(function () {
        $(this).on("submit", function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.each($("#customFile"), function (i, obj) {
                $.each(obj.files, function (j, file) {
                    formData.append("images[" + j + "]", file);
                });
            });
            $.each($("#customDoc"), function (i, obj) {
                $.each(obj.files, function (j, file) {
                    formData.append("files[" + j + "]", file);
                });
            });
            $.ajax({
                url: $(this).attr("action"),
                type: "POST",
                cache: false,
                dataType: "json",
                data: formData,
                processData: false,
                contentType: false,
                timeout: 600000,
                beforeSend: function () {
                    $(this)
                        .find("input, textarea, select, button[type=submit]")
                        .prop("disabled", true);
                },
                error: function (data) {
                         if (data.responseJSON.message == undefined)
                        {
                            data.responseJSON.message = data.message;
                        }
                        $(".alert-danger-title")
                            .text(
                                " Ошибка!"
                        );
                        $(".alert-danger-text")
                        .html(
                            "При отправке возникла ошибка:<br/>" +
                            data.responseJSON.message
                        );
                        $(".base-alert-danger").fadeIn(2000);
                        setTimeout(function(){
                          $(".base-alert-danger").fadeOut(2000);
                        }, 4500);

                    $(this)
                        .find("input, textarea, select, button[type=submit]")
                        .prop("disabled", false);
                },
                success: function (data) {
                    $(".modal").each(function () {
                        $(this).modal('hide');
                    })
                    $(".alert-success-title")
                            .text(
                                " Успех"
                        );
                        $(".alert-success-text")
                        .text(
                            data.message
                        );
                        $(".base-alert-success").fadeIn(2000);
                        setTimeout(function(){
                          $(".base-alert-success").fadeOut(2000);
                        }, 2500);
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                    setTimeout(function () {
                        $(this)
                        .find("input, textarea, select, button[type=submit]")
                        .prop("disabled", false);
                          }, 5000);
                },
            });
        });
    });

    /**
     * Easy selector helper function
     */
    const select = (el, all = false) => {
        el = el.trim();
        if (el) {
            if (all) {
                return [...document.querySelectorAll(el)];
            } else {
                return document.querySelector(el);
            }
        }
    };

    /**
     * Easy event listener function
     */
    const on = (type, el, listener, all = false) => {
        let selectEl = select(el, all);
        if (selectEl) {
            if (all) {
                selectEl.forEach((e) => e.addEventListener(type, listener));
            } else {
                selectEl.addEventListener(type, listener);
            }
        }
    };

    /**
     * Easy on scroll event listener
     */
    const onscroll = (el, listener) => {
        el.addEventListener("scroll", listener);
    };

    /**
     * Scrolls to an element with header offset
     */
    const scrollto = (el) => {
        let header = select("#header");
        let offset = header.offsetHeight;

        if (!header.classList.contains("header-scrolled")) {
            offset -= 16;
        }

        let elementPos = select(el).offsetTop;
        window.scrollTo({
            top: elementPos - offset,
            behavior: "smooth",
        });
    };

    /**
     * Toggle .header-scrolled class to #header when page is scrolled
     */
    let selectHeader = select("#header");
    if (selectHeader) {
        const headerScrolled = () => {
            if (window.scrollY > 100) {
                selectHeader.classList.add("header-scrolled");
            } else {
                selectHeader.classList.remove("header-scrolled");
            }
        };
        window.addEventListener("load", headerScrolled);
        onscroll(document, headerScrolled);
    }

    /**
     * Back to top button
     */
    let backtotop = select(".back-to-top");
    if (backtotop) {
        const toggleBacktotop = () => {
            if (window.scrollY > 100) {
                backtotop.classList.add("active");
            } else {
                backtotop.classList.remove("active");
            }
        };
        window.addEventListener("load", toggleBacktotop);
        onscroll(document, toggleBacktotop);
    }

    /**
     * Mobile nav toggle
     */
    on("click", ".mobile-nav-toggle", function (e) {
        select("#navbar").classList.toggle("navbar-mobile");
        this.classList.toggle("bi-list");
        this.classList.toggle("bi-x");
    });

    /**
     * Mobile nav dropdowns activate
     */
    on(
        "click",
        ".navbar .dropdown > a",
        function (e) {
            if (select("#navbar").classList.contains("navbar-mobile")) {
                e.preventDefault();
                this.nextElementSibling.classList.toggle("dropdown-active");
            }
        },
        true
    );

    /**
     * Scrool with ofset on links with a class name .scrollto
     */
    on(
        "click",
        ".scrollto",
        function (e) {
            if (select(this.hash)) {
                e.preventDefault();

                let navbar = select("#navbar");
                if (navbar.classList.contains("navbar-mobile")) {
                    navbar.classList.remove("navbar-mobile");
                    let navbarToggle = select(".mobile-nav-toggle");
                    navbarToggle.classList.toggle("bi-list");
                    navbarToggle.classList.toggle("bi-x");
                }
                scrollto(this.hash);
            }
        },
        true
    );

    /**
     * Scroll with ofset on page load with hash links in the url
     */
    window.addEventListener("load", () => {
        if (window.location.hash) {
            if (select(window.location.hash)) {
                scrollto(window.location.hash);
            }
        }
    });

    /**
     * Animation on scroll
     */
    window.addEventListener("load", () => {
        AOS.init({
            duration: 2000,
            easing: "ease-in-out",
            once: true,
            mirror: true,
        });
    });
})();
