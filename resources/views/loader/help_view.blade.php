<div class="col-lg-6">
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Информация о заявке</h6>
        <div class="card-title">
            <div class="block" style="cursor: pointer;">
                <a style="color: #757575;" class="hover" onclick="window.history.back()">
                     <i class="fas fa-arrow-left fa-lg"></i>
                </a> <span class="hidden">Назад</span>
                    <!-- скрытый элемент -->
            </div>
            <div class="block d-print-none">
                <a style="color: #757575;" class="hover" href="javascript:(print());">
                    <i class="fas fa-print fa-lg"></i>
                </a> <span class="hidden">Печать</span>
                <!-- скрытый элемент -->
            </div>
        </div>
    </div>
    <div class="card-body">
        <p class="text-primary">Номер заявки</p>
        <p>{{ $item->app_number}}</p>
        <hr>
        <p class="text-primary">Категория заявки</p>
        <p>{{ $item->category->description }}</p>
        <hr>
        <p class="text-primary">Кабинет</p>
        <p>№{{ $item->user->cabinet->description}}</p>
        <hr>
        <p class="text-primary">ФИО отправителя заявки</p>
        <p>{{ $item->user->lastname }} {{ $item->user->firstname }} {{ $item->user->patronymic }}</p>
        <hr>
        <p class="text-primary">Дата подачи заявки</p>
        <p>{{ $item->calendar_request }}</p>
        <hr>
        <p class="text-primary">Описание заявки</p>
        <p>{{ $item->description_long }}</p>
        <hr>
        <p class="text-primary">Вложения</p>
        @if ($item->images==null)
        Вложения отсуствуют
        @else
        <div class="slider">
            @foreach ($item->images as $image)
            <a href="{{ asset('storage/images/'.$image['url'].'') }}" data-fancybox="images">
                Посмотреть вложение
            </a>
            @endforeach
        </div>
        @endif
        <hr>
        <p class="text-primary">Ответ о выполнении заявки</p>
        @if ($item->info_final==null)
        Заявка ещё не выполнена или не взята в работу
        @else
        {{ $item->info_final }}
        @endif
        <hr>
        <p class="text-primary">Вложения к ответам</p>
        @if ($item->images_final==null)
        Вложения отсуствуют
        @else
        <div class="slider">
            @foreach ($item->images_final as $image)
            <a href="{{ asset('storage/images/'.$image['url'].'') }}" data-fancybox="images">
                Посмотреть вложение
            </a>
            @endforeach
        </div>
        @endif
        <hr>
        @if ($item->status->id ===1)
        <div class="block">
        @can('accept help')
            <a href="" class="btn btn-primary btn-sm hover btn-modal" data-toggle="modal" data-target="#acceptHelp"
                data-id="{{$item->id}}">
                Назначить исполнителя
            </a>
        @endcan
        @can('edit help')
            <a href="{{ route(config('constants.help.edit'),$item->id) }}" class="btn btn-success btn-sm hover">
                Редактировать заявку
            </a>
        @endcan
        @can('reject help')
            <a href="" class="btn btn-danger btn-sm hover btn-modal" data-toggle="modal" data-target="#rejectHelp"
                data-id="{{$item->id}}">
                Отклонить заявку
            </a>
        @endcan
        </div>
        @endif
        @if($item->status->id ===2)
        <div class="block">
            <a href="" class="btn btn-primary btn-sm hover btn-modal" data-toggle="modal" data-target="#executeHelp"
                data-id="{{$item->id}}">
                Выполнить заявку
            </a>
        </div>
        <div class="block">
        @can('redefine help')
            <a href="" class="btn btn-info btn-sm hover btn-modal" data-toggle="modal" data-target="#redefineHelp"
                data-id="{{$item->id}}">
                Передать заявку
            </a>
        @endcan
        </div>
        @endif
    </div>
</div>
</div>
<div class="col-lg-6">
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Информация об исполнении</h6>
        </div>
        <div class="card-body">
            <p class="text-primary">Статус заявки</p>
            <p class="badge badge-{{ $item->status->color }}">{{ $item->status->description }}</p>
            <hr>
            <p class="text-primary">Приоритет заявки</p>
            <p>{{ $item->priority->description }}</p>
            <hr>
            <p class="text-primary">Исполнитель заявки</p>
            @if ($item->executor_id==null)
            Исполнитель ещё не назначен
            @else
            {{ $item->executor->lastname }} {{ $item->executor->firstname }} {{ $item->executor->patronymic }}
            @endif
            <hr>
            <p class="text-primary">Дата принятия заявки</p>
            @if ($item->calendar_accept==null)
            Заявка ещё не принята
            @else
            {{ $item->calendar_accept }}
            @endif
            <hr>
            <p class="text-primary">Дата выполнения заявки</p>
            @if ($item->calendar_final==null)
            Заявка ещё не выполнена
            @else
            {{ $item->calendar_final }}
            @endif
            <hr>
            <p class="text-primary">Дата предупреждения о просрочке заявки</p>
            @if ($item->calendar_warning==null)
            Заявка ещё не взята в работу
            @else
            {{ $item->calendar_warning }}
            @endif
            <hr>
            <p class="text-primary">Максимальная дата для выполнения заявки</p>
            @if ($item->calendar_execution==null)
            Заявка ещё не взята в работу
            @else
            {{ $item->calendar_execution }}
            @endif
            <hr>
            <p class="text-primary">Время выполнения заявки</p>
            @if ($item->lead_at==null)
            Заявка ещё не выполнена
            @else
            @if ($item->lead_at['day']>0){{ $item->lead_at['day'] }} дн. @endif @if ($item->lead_at['hour']>0){{ $item->lead_at['hour'] }} ч. @endif @if ($item->lead_at['minute']>0){{ $item->lead_at['minute'] }} мин. @endif
            @endif
            <hr>
            @if ($item->work_id!=auth()->user()->id)
            <p class="text-primary">Информация для выполнения</p>
            @if ($item->info==null)
            Информация отсуствует
            @else
            {{ $item->info }}
            @endif
            <hr>
            @endif
        </div>
    </div>
</div>
