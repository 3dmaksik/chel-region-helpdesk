@extends('layouts.app')
@section('components.grid')
col-lg-4
@endsection
@section('row')
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Изменить статус</h6>
      <div class="card-title">
        <div class="block">
          <a style="color: #757575;" class="hover" href="{{ route(config('constants.status.index')) }}">
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
      <form id="formValidate" method="POST" action="{{ route(config('constants.status.update'),$item->id) }}">
        @method('PATCH')
        @csrf
        <div class="form-group">
            <label for="">Наименование</label>
            <input type="text" name="description" value="{{ $item->description }}" class="form-control @error('description') is-invalid @enderror" id="description" aria-describedby="textHelp" placeholder="Пр. 1" autocomplete="off">
            <small id="textHelp" class="form-text text-muted">Введите статус</small>
            @error('description')
            <small class="invalid-feedback">Такой статус уже существует или превышено количество символов.</small>
            @enderror
          </div>
          <div class="form-group">
              <label for="select2-color">Выберите цвет статуса</label>
              <select class="select2-single form-control" name="color" id="select2-color">
                @foreach( config("color")  as $color=>$value)
                <option @if ($value['slug']=="$item->color") selected @endif value="{{ $value['slug'] }}">{{ $value['name'] }}</option>
                @endforeach
              </select>
        </div>
        <input class="btn btn-primary" type="submit" value="Отправить" />
        <a class="btn btn-secondary" href="{{ route(config('constants.status.index')) }}">Отменить</a>
      </form>
    </div>
  </div>
@endsection
