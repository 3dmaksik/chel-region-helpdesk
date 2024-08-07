@extends('layouts.app')
@section('row')
<div class="col-lg-6">
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Добавить пользователя</h6>
        <div class="card-title">
            <div class="block">
                <a style="color: #757575;" class="hover" href="{{ route(config('constants.users.index')) }}">
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
        <form id="formValidate" class="form-submit" method="POST" action="{{ route(config('constants.users.store')) }}">
            <div class="form-group">
                <label for="">Логин</label>
                <input type="text" name="name" value="" class="form-control" id="name" aria-describedby="textName"
                    autocomplete="off" required>
                <small id="textName" class="form-text text-muted">Введите логин пользователя</small>
            </div>
            <div class="form-group">
                <label for="">Пароль</label>
                <input type="password" name="password" class="form-control" id="password"
                    aria-describedby="textPassword" autocomplete="off" required>
                <small id="textPassword" class="form-text text-muted">Введите новый пароль пользователя</small>
            </div>
            <div class="form-group">
                <label for="">Фамилия</label>
                <input type="text" name="lastname" value="" class="form-control" id="lastname"
                    aria-describedby="textLastname" placeholder="Фамилия" autocomplete="off" required>
                <small id="textLastname" class="form-text text-muted">Введите фамилию пользователя</small>
            </div>
            <div class="form-group">
                <label for="">Имя</label>
                <input type="text" name="firstname" value="" class="form-control" id="firstname"
                    aria-describedby="textName" placeholder="Имя" autocomplete="off" required>
                <small id="textName" class="form-text text-muted">Введите имя пользователяа</small>
            </div>
            <div class="form-group">
                <label for="">Отчество</label>
                <input type="text" name="patronymic" value="" class="form-control" id="patronymic"
                    aria-describedby="textPatronymic" placeholder="Отчество" autocomplete="off">
                <small id="textPatronymic" class="form-text text-muted">Введите отчество пользователя если есть</small>
            </div>
            <div class="form-group">
                <label for="select2-cabinet">Выберите кабинет</label>
                <select class="select2-cabinet form-control" name="cabinet_id" id="select2-cabinet">
                </select>
                <small id="textCabinet" class="form-text text-muted">Выберите кабинет пользователя</small>
            </div>
            <div class="form-group">
                <label for="role">Роль</label>
                <select class=" form-control" name="role" id="role">
                    @foreach( $items['roles'] as $item)
                    <option>{{ $item }}</option>
                    @endforeach
                </select>
                <small id="textRole" class="form-text text-muted">Выберите роль пользователя</small>
            </div>
            <input class="btn btn-primary" type="submit" value="Отправить" />
            @if (url()->previous()!==url()->current())
            <a class="btn btn-secondary" href="{{ route(config('constants.users.index')) }}">Отменить</a>
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
