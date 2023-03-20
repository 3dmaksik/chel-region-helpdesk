@extends('layouts.app')
@section('components.grid')
col-lg-4
@endsection
@section('row')
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Добавить приоритет</h6>
      <div class="card-title">
        <div class="block">
          <a style="color: #757575;" class="hover" href="{{ route(config('constants.priority.index')) }}">
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
      <form id="formValidate" method="POST" action="{{ route(config('constants.priority.store')) }}">
        <div class="form-group">
            <div class="text-center">
                <div id="sent-message-send" style="display: none"> </div>
            </div>
            <label for="">Название</label>
            <input type="text" name="description" value="" class="form-control" id="description" aria-describedby="textHelp" placeholder="Средний" autocomplete="off">
            <small id="textHelp" class="form-text text-muted">Введите наименование приоритета</small>
        </div>
        <div class="form-group">
            <label for="">Позиция</label>
            <input type="text" name="rang" value="" class="form-control" id="rang" aria-describedby="textRang" placeholder="3" autocomplete="off">
            <small id="textRang" class="form-text text-muted">Укажите позицию от 1 до 9</small>
        </div>
        <div class="form-group">
            <label for="">Время</label>
            <input type="text" name="warning_timer" value="" class="form-control" id="warning-timer" aria-describedby="textWarningTimer" placeholder="1" autocomplete="off">
            <small id="textWarningTimer" class="form-text text-muted">Укажите длительность для предупреждения приоритета в часах</small>
        </div>
        <div class="form-group">
            <label for="">Время</label>
            <input type="text" name="danger_timer" value="" class="form-control" id="danger-timer" aria-describedby="textDangerTimer" placeholder="2" autocomplete="off">
            <small id="textDangerTimer" class="form-text text-muted">Укажите длительность для просрочки приоритета в часах</small>
        </div>
        <input class="btn btn-primary" type="submit" value="Отправить" />
        <a class="btn btn-secondary" href="{{ route(config('constants.priority.index')) }}">Отменить</a>
      </form>
    </div>
  </div>
@endsection
