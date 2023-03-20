@extends('layouts.app')
@section('components.grid')
col-lg-4
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
      <form id="formValidate" method="POST" action="{{ route(config('constants.work.store')) }}">
        @csrf
        <div class="form-group">
            <label for="">Фамилия</label>
            <input type="text" name="lastname" value="@error('lastname'){{old('lastname')}}@enderror" class="form-control @error('lastname') is-invalid @enderror" id="lastname" aria-describedby="textLastname" placeholder="Фамилия" autocomplete="off">
            <small id="textLastname" class="form-text text-muted">Введите фамилию сотрудника</small>
            @error('lastname')
            <small class="invalid-feedback">Превышено количество символов.</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="">Имя</label>
            <input type="text" name="firstname" value="@error('firstname'){{old('firstname')}}@enderror" class="form-control @error('firstname') is-invalid @enderror" id="firstname" aria-describedby="textName" placeholder="Имя" autocomplete="off">
            <small id="textName" class="form-text text-muted">Введите имя сотрудника</small>
            @error('firstname')
            <small class="invalid-feedback">Превышено количество символов.</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="">Отчество</label>
            <input type="text" name="patronymic" value="@error('patronymic'){{old('patronymic')}}@enderror" class="form-control @error('patronymic') is-invalid @enderror" id="patronymic" aria-describedby="textPatronymic" placeholder="Отчество" autocomplete="off">
            <small id="textPatronymic" class="form-text text-muted">Введите отчество сотрудника если есть</small>
            @error('patronymic')
            <small class="invalid-feedback">Превышено количество символов.</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="select2-cabinet">Выберите кабинет</label>
            <select class="select2-single form-control" name="cabinet_id" id="select2-cabinet">
              @foreach( $items['cabinets'] as $item)
              <option @if (old('cabinet_id')=="$item->id") selected @endif value="{{ $item->id }}">{{ $item->description }}</option>
              @endforeach
            </select>
            <small id="textCabinet" class="form-text text-muted">Выберите кабинет сотрудника</small>
        </div>
        <div class="form-group">
            <label for="select2-users">Выберите пользователя</label>
            <select class="select2-single form-control" name="user_id" id="select2-users">
              @foreach( $items['users'] as $item)
              <option @if (old('user_id')=="$item->id") selected @endif value="{{ $item->id }}">{{ $item->name }}</option>
              @endforeach
            </select>
            <small id="textUser" class="form-text text-muted">Выберите кабинет сотрудника</small>
        </div>
        <input class="btn btn-primary" type="submit" value="Отправить" />
        <a class="btn btn-secondary" href="{{ route(config('constants.work.index')) }}">Отменить</a>
      </form>
    </div>
  </div>
@endsection
