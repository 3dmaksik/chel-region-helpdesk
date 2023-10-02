<div class="col-lg-12">
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Информация о заявке</h6>
        <div class="card-title">
            <div class="block d-print-none">
                <a style="color: #757575;" class="hover" href="javascript:(print());">
                    <i class="fas fa-print fa-lg"></i>
                </a> <span class="hidden">Печать</span>
                <!-- скрытый элемент -->
            </div>
            <div class="block" style="cursor: pointer;">
                <a style="color: #757575;" class="hover" onclick="window.close()">
                     <i class="fas fa-circle-xmark fa-lg"></i>
                </a> <span class="hidden">Закрыть</span>
                    <!-- скрытый элемент -->
            </div>
        </div>
    </div>
    <div class="card-body">
        <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Информация о заявке</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="help-tab" data-toggle="tab" href="#help" role="tab" aria-controls="help" aria-selected="false">Информация об исполнении</a>
    </li>
  </ul>
  <!-- Tab panes -->
  <div class="tab-content">
    <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <br/>
        <p class="text-primary">Номер заявки</p>
        <p>{{ $item['data']->app_number}}</p>
        <hr>
        <p class="text-primary">Категория заявки</p>
        <p>{{ $item['data']->category->description }}</p>
        <hr>
        <p class="text-primary">Кабинет</p>
        <p>№{{ $item['data']->user->cabinet->description}}</p>
        <hr>
        <p class="text-primary">ФИО отправителя заявки</p>
        <p>{{ $item['data']->user->lastname }} {{ $item['data']->user->firstname }} {{ $item['data']->user->patronymic }}</p>
        <hr>
        <p class="text-primary">Дата подачи заявки</p>
        <p>{{ $item['data']->calendar_request }}</p>
        <hr>
        <p class="text-primary">Описание заявки</p>
        <p>{{ $item['data']->description_long }}</p>
        <hr>
        <p class="text-primary">Вложения</p>
        @if ($item['data']->images===null)
        Вложения отсуствуют
        @else
        <div class="slider">
            @foreach ($item['data']->images as $image)
            <a href="{{ asset('storage/images/'.$image['url'].'') }}" data-fancybox="images">
                Посмотреть вложение
            </a>
            @endforeach
        </div>
        @endif
        <hr>
        @if ($item['data']->info_final!==null)
        <p class="text-primary">Ответ о выполнении заявки</p>
        {{ $item['data']->info_final }}
        <hr>
        <p class="text-primary">Вложения к ответам</p>
        @if ($item['data']->images_final===null)
        Вложения отсуствуют
        @else
        <div class="slider">
            @foreach ($item['data']->images_final as $image)
            <a href="{{ asset('storage/images/'.$image['url'].'') }}" data-fancybox="images">
                Посмотреть вложение
            </a>
            @endforeach
        </div>
        @endif
        <hr>
        @endif
        @if ($item['data']->status->id === 1)
        <div class="block">
        @can('accept help')
            <a href="" class="btn btn-primary btn-sm hover btn-modal" data-toggle="modal" data-target="#acceptHelp"
                data-id="{{$item['data']->id}}">
                Назначить исполнителя
            </a>
        @endcan
        @can('reject help')
            <a href="" class="btn btn-danger btn-sm hover btn-modal" data-toggle="modal" data-target="#rejectHelp"
                data-id="{{$item['data']->id}}">
                Отклонить заявку
            </a>
        @endcan
        </div>
        @endif
        @if($item['data']->status->id ===2)
        <div class="block">
            <a href="" class="btn btn-primary btn-sm hover btn-modal" data-toggle="modal" data-target="#executeHelp"
                data-id="{{$item['data']->id}}">
                Выполнить заявку
            </a>
        </div>
        <div class="block">
        @can('edit help')
            <a href="" class="btn btn-success btn-sm hover btn-modal" data-toggle="modal" data-target="#editHelp"
                    data-id="{{$item['data']->id}}">
                    Редактировать заявку
            </a>
        @endcan
        @can('redefine help')
            <a href="" class="btn btn-info btn-sm hover btn-modal" data-toggle="modal" data-target="#redefineHelp"
                data-id="{{$item['data']->id}}">
                Передать заявку
            </a>
        @endcan
        </div>
        @endif
    </div>
    <div class="tab-pane" id="help" role="tabpanel" aria-labelledby="help-tab">
        <br/>
        <p class="text-primary">Статус заявки</p>
        <p class="badge badge-{{ $item['data']->status->color }}">{{ $item['data']->status->description }}</p>
        <hr>
        <p class="text-primary">Приоритет заявки</p>
        <p>{{ $item['data']->priority->description }}</p>
        <hr>
        @if ($item['data']->executor_id!==null)
        <p class="text-primary">Исполнитель заявки</p>
        {{ $item['data']->executor->lastname }} {{ $item['data']->executor->firstname }} {{ $item['data']->executor->patronymic }}
        <hr>
        @endif
        @if ($item['data']->calendar_accept!==null)
        <p class="text-primary">Дата принятия заявки</p>
        {{ $item['data']->calendar_accept }}
        <hr>
        @endif
        @if ($item['data']->calendar_final!==null)
        <p class="text-primary">Дата выполнения заявки</p>
        {{ $item['data']->calendar_final }}
        <hr>
        @endif
        @if ($item['data']->calendar_warning!==null)
        <p class="text-primary">Дата предупреждения о просрочке заявки</p>
        {{ $item['data']->calendar_warning }}
        <hr>
        @endif
        @if ($item['data']->calendar_execution!==null)
        <p class="text-primary">Максимальная дата для выполнения заявки</p>
        {{ $item['data']->calendar_execution }}
        <hr>
        @endif
        @if ($item['data']->lead_at!==null)
        <p class="text-primary">Время выполнения заявки</p>
        @if ($item['data']->lead_at['day']>0){{ $item['data']->lead_at['day'] }} дн. @endif @if ($item['data']->lead_at['hour']>0){{ $item['data']->lead_at['hour'] }} ч. @endif @if ($item['data']->lead_at['minute']>0){{ $item['data']->lead_at['minute'] }} мин. @endif
        <hr>
        @endif
        @if ($item['data']->executor_id===auth()->user()->id || auth()->user()->getRoleNames()[0] === 'superAdmin' || auth()->user()->getRoleNames()[0] === 'admin')
        <p class="text-primary">Информация для выполнения</p>
        @if ($item['data']->info==null)
        Информация отсуствует
        @else
        {{ $item['data']->info }}
        @endif
        <hr>
        @endif
    </div>
  </div>
    </div>
</div>
</div>
