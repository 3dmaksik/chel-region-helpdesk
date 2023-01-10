import './bootstrap.js';

$(function () {
    Echo.private('App.Models.User.' + window.Laravel.user)
        .notification((notification) => {
            console.log(notification.status + ' '+ notification.category + ' ' + notification.cabinet);
        });
    let id = 0;
    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
    $.ajax({
        url: '/api/help/new',
        method: 'get',
        dataType: 'json',
        data: {"_token": CSRF_TOKEN},
        success: function (data) {
            let datacount=JSON.parse(data);
            if (datacount == 0)
            {
                $('#counter').text('');
                $('#new_count_text').text('У вас нет новых заявок');
            }
            else
            {
                $('#counter').text(datacount);
                $('#new_count_text').text('У вас новых заявок: '+ datacount);
           }
        }
    });
    $.ajax({
        url: '/api/help/now',
        method: 'get',
        dataType: 'json',
        data: {"_token": CSRF_TOKEN},
        success: function (data) {
            let datacount=JSON.parse(data);
            if (datacount == 0)
            {
                $('#now_count_text').text('У вас нет заявок на исполнении');
            }
            else
            {
                $('#now_count_text').text('У вас заявок на исполнении: ' + datacount);
            }
        }
    });
    $.ajax({
        url: '/api/work/all',
        method: 'get',
        dataType: 'json',
        data: {"_token": CSRF_TOKEN},
        success: function (data) {
        let datawork = JSON.parse(data);
        console.log(datawork);
            const sound = new Howl({
                src: [data],
                html5: true
            });
        }
    });
    $.ajax({
        url: '/api/help/all',
        method: 'post',
        dataType: 'json',
        data: {"_token": CSRF_TOKEN},
        success: function (data) {
            const obj = JSON.parse(data);
            for (var i = 0; i < obj.work.length; i++) {
                var counter = obj.work[i];
                if (counter.patronymic==null) counter.patronymic='';
                $('#accept-select2-work').append('<option value="'+counter.id+'">'+ counter.lastname +' '+counter.firstname+' '+counter.patronymic+'</option>');
                $('#redefine-select2-work').append('<option value="'+counter.id+'">'+ counter.lastname +' '+counter.firstname+' '+counter.patronymic+'</option>');
            }
            for (var i = 0; i < obj.priority.length; i++) {
                var counter = obj.priority[i];
                $('#accept-select2-priority').append('<option value="'+counter.id+'">'+ counter.description +'</option>');
            }
        }
    });
    $( "#description" ).focus(function() {
        if($(this).hasClass('is-invalid'))
        {
            $(this).removeClass('is-invalid');
        }
    });
    $( "#select2-description-long" ).focus(function() {
        if($(this).hasClass('is-invalid'))
        {
            $(this).removeClass('is-invalid');
        }
    });
    $( ".form-modal-info" ).focus(function() {
        if($(this).hasClass('is-invalid'))
        {
            $(this).removeClass('is-invalid');
            $('.invalid-feedback').text('');
        }
    });
    $('.select2-single').select2({
        language: "ru"
    });
    $('.custom-file-input').change(function() {
        if ($(this).val() != '') $(this).prev().text('Выбрано файлов: ' + $(this)[0].files.length);
        else $(this).prev().text('Выберите файлы');
    });
})
