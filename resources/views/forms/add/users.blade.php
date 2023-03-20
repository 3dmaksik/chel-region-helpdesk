@extends('layouts.app')
@section('components.grid')
col-lg-6
@endsection
@section('row')
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Добавить сотрудника</h6>
      <div class="card-title">
        <div class="block">
          <a style="color: #757575;" class="hover" href="{{ route(config('constants.work.index')) }}">
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
      <form id="formValidate" method="POST" action="{{ route(config('constants.users.store')) }}">
        @csrf
        <div class="form-group">
            <label for="">Логин</label>
            <input type="text" name="name" value="@error('name'){{old('name')}}@enderror" class="form-control @error('name') is-invalid @enderror" id="name" aria-describedby="textName" autocomplete="off">
            <small id="textName" class="form-text text-muted">Введите логин сотрудника</small>
            @error('name')
            <small class="invalid-feedback">Такой логин уже есть.</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="">Пароль</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" aria-describedby="textPassword" autocomplete="off">
            <small id="textPassword" class="form-text text-muted">Введите пароль сотрудника</small>
            @error('name')
            <small class="invalid-feedback">Пароль не введён.</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="select2-role">Роль</label>
            <select class="select2-single form-control" name="role" id="select2-role">
              @foreach( $items['roles'] as $item)
              <option>{{ $item }}</option>
              @endforeach
            </select>
            <small id="textCabinet" class="form-text text-muted">Выберите роль сотрудника</small>
        </div>
        <input class="btn btn-primary" type="submit" value="Отправить" />
        <a class="btn btn-secondary" href="{{ route(config('constants.users.index')) }}">Отменить</a>
      </form>
    </div>
  </div>
@endsection
@section('components.grid.right')
col-lg-6
@endsection
@section('row.right')
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Описание ролей</h6>
    </div>
    <div class="card-body">
        <ul class="list-group">
            <li class="list-group-item"><strong>superAdmin</strong>-Роль Главного администратора. Доступны все права.</li>
            <li class="list-group-item"><strong>admin</strong>-Роль администратора. Доступны все права, кроме меню списков. </li>
            <li class="list-group-item"><strong>manager</strong>-Роль исполнителя. Доступны все права связанные с исполнением заявки.</li>
            <li class="list-group-item"><strong>user</strong>-Роль пользователя. Доступны все права связанные с подачей заявки.</li>
        </ul>
    </div>
</div>
@endsection
