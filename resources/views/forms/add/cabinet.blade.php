@extends('layouts.app')
@section('components.grid')
col-lg-4
@endsection
@section('row')
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Добавить кабинет</h6>
      <div class="card-title">
        <div class="block">
          <a style="color: #757575;" class="hover" href="{{ route(config('constants.cabinet.index')) }}">
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
      <form id="formValidate" method="POST" action="{{ route(config('constants.cabinet.store')) }}">
        @csrf
        <div class="form-group">
            <label for="">Наименование</label>
            <input type="text" name="description" value="@error('description'){{old('description')}}@enderror" class="form-control @error('description') is-invalid @enderror" id="description" aria-describedby="textHelp" placeholder="Пр. 1" autocomplete="off">
            <small id="textHelp" class="form-text text-muted">Введите номер кабинета</small>
            @error('description')
            <small class="invalid-feedback">Такой кабинет уже существует или неправильно указано значение</small>
            @enderror
        </div>
        <input class="btn btn-primary" type="submit" value="Отправить" />
        <a class="btn btn-secondary" href="{{ route(config('constants.cabinet.index')) }}">Отменить</a>
      </form>
    </div>
  </div>
@endsection
