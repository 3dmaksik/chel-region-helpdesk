@extends('layouts.app')
@section('row')
<div class="col-lg-6">
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Редактировать пользователя</h6>
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
        <form id="formValidate" class="form-submit" method="POST" action="{{ route(config('constants.users.update'),$items['user']->id) }}">
            @method('PUT')
            <div class="form-group">
                <label for="">Логин</label>
                <input type="text" name="name" value="{{ $items['user']->name }}" class="form-control" id="name"
                    aria-describedby="textName" autocomplete="off" required>
                <small id="textName" class="form-text text-muted">Введите логин пользователя</small>
            </div>
            <div class="form-group">
                <label for="">Фамилия</label>
                <input type="text" name="lastname" value="{{ $items['user']->lastname }}" class="form-control"
                    id="lastname" aria-describedby="textLastname" placeholder="Фамилия" autocomplete="off" required>
                <small id="textLastname" class="form-text text-muted">Введите фамилию сотрудника</small>
            </div>
            <div class="form-group">
                <label for="">Имя</label>
                <input type="text" name="firstname" value="{{ $items['user']->firstname }}" class="form-control"
                    id="firstname" aria-describedby="textName" placeholder="Имя" autocomplete="off" required>
                <small id="textName" class="form-text text-muted">Введите имя сотрудника</small>
            </div>
            <div class="form-group">
                <label for="">Отчество</label>
                <input type="text" name="patronymic" value="{{ $items['user']->patronymic }}" class="form-control"
                    id="patronymic" aria-describedby="textPatronymic" placeholder="Отчество" autocomplete="off">
                <small id="textPatronymic" class="form-text text-muted">Введите отчество сотрудника если есть</small>
            </div>
            <div class="form-group">
                <label for="select2-cabinet">Выберите кабинет</label>
                <select class="select2-cabinet form-control" name="cabinet_id" id="select2-cabinet">
                    <option selected value="{{ $items['user']->cabinet->id }}"> {{$items['user']->cabinet->description }} </option>
                </select>
                <small id="textCabinet" class="form-text text-muted">Выберите кабинет сотрудника</small>
            </div>
            <div class="form-group">
                <label for="role">Роль</label>
                <select class="form-control" name="role" id="role">
                    @foreach( $items['roles'] as $item)
                    <option @if ($items['user']->getRoleNames()[0]==$item) selected @endif
                        value="@if ($items['role']==$item) {{ $items['role'] }} @else {{ $item }}@endif">
                        @if ($items['role']==$item) {{ $items['role'] }} @else {{ $item }}@endif</option>
                    @endforeach
                </select>
                <small id="textCabinet" class="form-text text-muted">Выберите роль пользователя</small>
            </div>
            <input class="btn btn-primary" type="submit" value="Отправить" />
            @if (url()->previous()!==url()->current())
            <a class="btn btn-secondary" href="{{ url()->previous() }}">Отменить</a>
            @endif
        </form>
    </div>
</div>
</div>
<div class="col-lg-6">
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
