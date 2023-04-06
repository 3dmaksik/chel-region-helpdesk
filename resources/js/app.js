import "./bootstrap.js";

$(function () {
    let CSRF_TOKEN = $('meta[name="_token"]').attr("content");
    let sendForm = $("#formValidate");
    let acceptForm = $("#formAccept");
    let executeForm = $("#formExecute");
    let redefineForm = $("#formRedefine");
    let rejectForm = $("#formReject");
    let updatePasswordForm = $("#formValidatePassword");
    let updateSettingsForm = $("#formValidateSettings");

    let page = $(".current-page").text();

    $.ajaxSetup({
        headers: { "X-CSRF-TOKEN": CSRF_TOKEN },
    });

    function loadNew(method, route) {
        if ($("div").hasClass(method)) {
            $.post(route + "?page=" + page + "", function (data) {
                $("." + method).html(data);
            });
        }
    }
    Echo.private("App.Models.User." + window.Laravel.user).notification(
        (notification) => {
            loadNew(notification.method, notification.route);
            if (notification.method == "newadm") {
                newCount();
                sound.play();
            }
            if (notification.method == "workeradm") {
                nowCount();
            }
        }
    );

    sendAllForm(sendForm, "send");
    sendAllForm(acceptForm, "accept");
    sendAllForm(executeForm, "execute");
    sendAllForm(redefineForm, "redefine");
    sendAllForm(rejectForm, "reject");
    sendAllForm(updatePasswordForm, "upPass");
    sendAllForm(updateSettingsForm, "upSettings");
    newCount();
    nowCount();
    function sendAllForm(form, inputMessage) {
        form.on("submit", function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.each($("input[type=file]"), function (i, obj) {
                $.each(obj.files, function (j, file) {
                    formData.append("images[" + j + "]", file);
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
                    $(form)
                        .find("input, textarea, select, button[type=submit]")
                        .prop("disabled", true);
                },
                error: function (data) {
                    $("#sent-message-" + inputMessage)
                        .hide(1500)
                        .empty();
                    if (data.responseJSON.message == "validation.required") {
                        $("#sent-message-" + inputMessage)
                            .append(
                                "<div class='alert alert-danger'>Ошибка. Неверно заполнены поля!</div>"
                            )
                            .slideDown(1500);
                    } else if (
                        data.responseJSON.message == "validation.unique"
                    ) {
                        $("#sent-message-" + inputMessage)
                            .append(
                                "<div class='alert alert-danger'>Ошибка. Данные уже существуют!</div>"
                            )
                            .slideDown(1500);
                    } else {
                        $("#sent-message-" + inputMessage)
                            .append(
                                "<div class='alert alert-danger'>Ошибка сервера. Обратитесь к администратору. Наименование ошибки:" +
                                    data.responseJSON.message +
                                    "</div>"
                            )
                            .slideDown(1500);
                    }
                    $(form)
                        .find("input, textarea, select, button[type=submit]")
                        .prop("disabled", false);
                },
                success: function (data) {
                    $("#sent-message-" + inputMessage)
                        .hide(1500)
                        .empty();
                    $("#sent-message-" + inputMessage)
                        .append(
                            "<div class='alert alert-success'>Запись успешно обработана!</div>"
                        )
                        .slideDown(1500);
                    $(form)
                        .find("input, textarea, select, button[type=submit]")
                        .prop("disabled", false);
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                },
            });
        });
    }
    function newCount() {
        $.ajax({
            url: "/api/help/new",
            method: "get",
            dataType: "json",
            success: function (data) {
                let datacount = JSON.parse(data);
                if (datacount == 0) {
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
    $.ajax({
        url: "/api/loader/get",
        method: "get",
        dataType: "json",
        error: function (data) {},
        success: function (data) {
            if (data.avatar != null) {
                $(".img-profile").attr(
                    "src",
                    "/storage/avatar/" + data.avatar.url
                );
            }
            else {
                $(".img-profile").attr(
                    "src",
                    "/img/boy.png"
                );
            }
            if (data.soundNotify != null) {
                const sound = new Howl({
                    src: ["/storage/sound/" + data.soundNotify.url],
                    html5: true,
                });
            }
        },
    });

    $.ajax({
        url: "/api/help/all",
        method: "post",
        dataType: "json",
        success: function (data) {
            const obj = JSON.parse(data);
            for (var i = 0; i < obj.user.length; i++) {
                var counter = obj.user[i];
                if (counter.patronymic == null) counter.patronymic = "";
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
    $(".select2-single").select2({
        language: "ru",
    });
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
    $(".remove-form").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: $(this).attr("action"),
            type: "POST",
            cache: false,
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            timeout: 600000,
            error: function (data) {},
            success: function (data) {
                setTimeout(function () {
                    location.reload();
                }, 3000);
            },
        });
    });
    $("#preloader").fadeOut("slow", function () {
        $(this).remove();
    });
});
