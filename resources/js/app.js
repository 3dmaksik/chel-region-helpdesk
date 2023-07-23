import "./bootstrap.js";

$(function () {
    let CSRF_TOKEN = $('meta[name="_token"]').attr("content");
    let page = $(".current-page").text();
    newCount();
    nowCount();
    $.ajaxSetup({
        headers: { "X-CSRF-TOKEN": CSRF_TOKEN },
    });

    Echo.private("App.Models.User." + window.Laravel.user).notification(
        (notification) => {
            loadNew(notification.method, notification.route);
            if (notification.method === "newadm") {
                newCount();
                sound.play();
            }
            if (notification.method === "workeradm") {
                nowCount();
            }
            if (notification.method === "expire") {
                expireNotify(notification.text, notification.count);
            }
        }
    );

    $(".select2-cabinet").select2({
        language: "ru",
        placeholder: 'Введите номер кабинета',
        ajax: {
            url: '/api/select2/cabinet',
            dataType: 'json',
            delay: 2,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        if (item.description !== undefined)
                        {
                            return {
                                text: item.description,
                                id: item.id
                            }
                        }
                    })
                };
            },
            cache: true
        }
    });

    if (localStorage.getItem('sound') === null)
    {
        const sound = new Howl({
            src: ["/sound/sound.ogg"],
            html5: true,
        });
    }
    jQuery.datetimepicker.setLocale("ru");
    jQuery("#datetimepicker").datetimepicker({
        format: "Y-m-d H:i:s",
    });

    $(".custom-file-input").on("change", function () {
        if ($(this).val() != "")
            $(this)
                .prev()
                .text("Выбрано файлов: " + $(this)[0].files.length);
        else $(this).prev().text("Выберите файлы");
    });
    $(".btn-modal").on('click', function () {
        $.ajax({
            url: "/api/help/all",
            method: "post",
            dataType: "json",
            success: function (data) {
                const obj = JSON.parse(data);
                for (var i = 0; i < obj.user.length; i++) {
                    var counter = obj.user[i];
                    if (counter.patronymic === null) counter.patronymic = "";
                    $("#accept-select2-user").append(
                        '<option value="' +
                            counter.id +
                            '">' +
                            counter.lastname +
                            " " +
                            counter.firstname +
                            " " +
                            counter.patronymic +
                            "</option>"
                    );
                    $("#redefine-select2-user").append(
                        '<option value="' +
                            counter.id +
                            '">' +
                            counter.lastname +
                            " " +
                            counter.firstname +
                            " " +
                            counter.patronymic +
                            "</option>"
                    );
                }
                for (var i = 0; i < obj.priority.length; i++) {
                    var counter = obj.priority[i];
                    $("#accept-select2-priority").append(
                        '<option value="' +
                            counter.id +
                            '">' +
                            counter.description +
                            "</option>"
                    );
                }
            },
        });
    })

    function loadNew(method, route) {
        if ($("div").hasClass(method)) {
            $.post(route + "?page=" + page + "", function (data) {
                $("." + method).html(data);
            });
        }
    }
        $(document).on("submit", '.form-submit', function (e) {
            e.preventDefault();
            let formid = $(this).attr('id');
            let form = document.querySelector('#'+formid);
            let formData = new FormData(form);
            $.each($("input[type=file]"), function (i, obj) {
                $.each(obj.files, function (j, file) {
                    formData.append("images[" + j + "]", file);
                });
            });
            $.ajax({
                url: $(form).attr("action"),
                type: "POST",
                cache: false,
                dataType: "json",
                data: formData,
                processData: false,
                contentType: false,
                timeout: 600000,
                beforeSend: function () {
                    $(form)
                        .find("input, textarea, select, button[type=submit]")
                        .prop("disabled", true);
                },
                error: function (data) {
                         if (data.responseJSON.message === undefined)
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

                    $(form)
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
                        }, 6500);
                    if (data.reload === true)
                    {
                        setTimeout(function(){
                            location.reload();
                          }, 7500);
                    }
                    $(form)
                        .find("input, textarea, select, button[type=submit]")
                        .prop("disabled", false);
                },
            });
            return false;
        });
    function newCount() {
        $.ajax({
            url: "/api/help/new",
            method: "get",
            dataType: "json",
            success: function (data) {
                let datacount = JSON.parse(data);
                if (datacount === 0) {
                    $("#counter").text("");
                    $("#new_count_text").text("Нет новых заявок");
                } else {
                    $("#counter").text(datacount);
                    $("#new_count_text").text(
                        "Всего новых заявок: " + datacount
                    );
                }
            },
        });
    }

    function nowCount() {
        $.ajax({
            url: "/api/help/now",
            method: "get",
            dataType: "json",
            success: function (data) {
                let datacount = JSON.parse(data);
                if (datacount == 0) {
                    $("#now_count_text").text("У вас нет заявок на исполнении");
                } else {
                    $("#now_count_text").text(
                        "У вас заявок на исполнении: " + datacount
                    );
                }
            },
        });
    }

    function expireNotify(text, count)
    {
        $(".alert-danger-title")
            .text(
            " Уведомление"
            );
        if (count > 0)
        {
            $(".alert-danger-text")
            .html(
            "У вас истекает или истёк срок заявки:<br/>" +
                text +
                "<br/>и ещё " + count
                );
        }
        else
        {
            $(".alert-danger-text")
            .html(
            "У вас истекает или истёк срок заявки:<br/>" +
               text
                );
        }
        $(".base-alert-danger").fadeIn(2000);
            setTimeout(function(){
            $(".base-alert-danger").fadeOut(2000);
            }, 6500);
    }

    $("#preloader").fadeOut("slow", function () {
        $(this).remove();
    });
});
