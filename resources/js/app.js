$(function () {
    let id=0;
    const sound = new Howl({
        src: ['/js/sound.ogg'],
        html5: true
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
    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
    var API_TOKEN=$('meta[name="api_token"]').attr('content');
    $.ajax({
        url: '/api/profile',
        method: 'post',
        dataType: 'json',
        data: {"token_type":"Bearer","api_token":API_TOKEN ,"_token": CSRF_TOKEN},
        success: function(data){
            console.log(data);
        }
    });
    $.ajax({
        url: '/api/help/all',
        method: 'post',
        dataType: 'json',
        data: {"token_type":"Bearer","api_token":API_TOKEN ,"_token": CSRF_TOKEN},
        success: function(data){
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
    function getHelp()
    {
        let count= $("#counter").text();
        $.ajax({
            url: '/panel/get/count/',
            type:'GET',
            success: function(data) {
               let datacount=JSON.parse(data);
               if (parseInt(count,10)!==parseInt(datacount.count_new,10))
               {
                   $('#counter').text(datacount.count_new);
                   $('#new_count').text('У вас новых заявок: '+ datacount.count_new);
                   $('#now_count').text('У вас заявок на исполнении: '+ datacount.count_now);
                   sound.play();
               }
            }
        });
        let getAjaxpage=$("#breadcumb-panel").text();
        if (getAjaxpage==1)
        {
        $.ajax({
            url: '/panel/get/count/'+count,
            type:'GET',
            success: function(data) {
                if (parseInt(data,10)!==1)
                {
                    $('#table-dynamic').prepend(data);
                    $('#table-dynamic tr:first').fadeIn(6000);
                    if ($('#table-dynamic tr').length>10)
                    {
                        $('#table-dynamic tr:last').fadeOut(6000).remove();
                    }
                }
            }
        });
        }

    }
    setInterval(getHelp, 60000);
})
