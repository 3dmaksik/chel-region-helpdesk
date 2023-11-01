@extends('layouts.app')
@section('row')
<div class="col-lg-4">
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Изменить приоритет </h6>
        <div class="card-title">
            <div class="block" style="cursor: pointer;">
                <a style="color: #757575;" class="hover" href="{{ url()->previous() === url()->current() ? route(config('constants.priority.index')): url()->previous()}}">
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
        <form id="formValidate" class="form-submit" method="POST" action="{{ route(config('constants.priority.update'),$item['data']->id) }}">
            @method('PATCH')
            <div class="form-group">
                <label for="">Название</label>
                <input type="text" name="description" value="{{ $item['data']->description }}" class="form-control"
                    id="description" aria-describedby="textHelp" placeholder="Средний" autocomplete="off" required>
                <small id="textHelp" class="form-text text-muted">Введите наименование приоритета</small>
            </div>
            <div class="form-group">
                <label for="">Позиция</label>
                <input type="text" name="rang" value="{{ $item['data']->rang }}" class="form-control" id="rang"
                    aria-describedby="textRang" placeholder="3" autocomplete="off" required>
                <small id="textRang" class="form-text text-muted">Укажите позицию от 1 до 9</small>
            </div>
            <div class="form-group">
                <label for="">Время</label>
                <input type="text" name="warning_timer" value="{{ $item['data']->warning_timer}}" class="form-control"
                    id="warning-timer" aria-describedby="textWarningTimer" placeholder="1" autocomplete="off" required>
                <small id="textWarningTimer" class="form-text text-muted">Укажите длительность для предупреждения
                    приоритета в часах</small>
            </div>
            <div class="form-group">
                <label for="">Время</label>
                <input type="text" name="danger_timer" value="{{ $item['data']->danger_timer }}" class="form-control"
                    id="danger-timer" aria-describedby="textDangerTimer" placeholder="2" autocomplete="off" required>
                <small id="textDangerTimer" class="form-text text-muted">Укажите длительность для просрочки приоритета в
                    часах</small>
            </div>
            <input class="btn btn-primary" type="submit" value="Отправить" />
            @if (url()->previous()!==url()->current())
            <a class="btn btn-secondary" href="{{ url()->previous() }}">Отменить</a>
            @endif
        </form>
    </div>
</div>
</div>
@endsection
