@extends('layouts.app')
@section('row')
<div class="col-lg-5">
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Просмотр сотрудника</h6>
        <div class="card-title">
            <div class="block" style="cursor: pointer;">
                <a style="color: #757575;" class="hover" href="{{ url()->previous() === url()->current() ? route(config('constants.users.index')): url()->previous()}}">
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
        <p class="text-primary">Фамилия</p>
        <p>{{ $item->lastname }}</p>
        <p class="text-primary">Имя</p>
        <p>{{ $item->firstname}}</p>
        <p class="text-primary">Отчество</p>
        @empty ($item->patronymic)
        <p>Нет отчества</p>
        @else
        <p>{{ $item->patronymic}}</p>
        @endempty
        <hr>
        <p class="text-primary">Кабинет</p>
        <p>№{{ $item->cabinet->description }}</p>
        <hr>
        <p class="text-primary">Пользователь</p>
        <p>{{ $item->name }}</p>
        @if(!empty($item->getRoleNames()))
        <p class="text-primary">Роль</p>
        <p> {{ $item->getRoleNames()[0] }}</p>
        @endif
    </div>
</div>
</div>
<div class="col-lg-7">
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Описание ролей</h6>
    </div>
    <div class="card-body">
        <ul class="list-group">
            <li class="list-group-item"><strong>superAdmin</strong>-Роль Главного администратора. Доступны все права.
            </li>
            <li class="list-group-item"><strong>admin</strong>-Роль администратора. Доступны все права, кроме меню
                списков. </li>
            <li class="list-group-item"><strong>manager</strong>-Роль исполнителя. Доступны все права связанные с
                исполнением заявки.</li>
            <li class="list-group-item"><strong>user</strong>-Роль пользователя. Доступны все права связанные с подачей
                заявки.</li>
        </ul>
    </div>
</div>
</div>
@endsection
