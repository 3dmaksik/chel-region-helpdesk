@extends('layouts.app')
@section('components.grid')
col-lg-4
@endsection
@section('row')
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Добавить категорию</h6>
        <div class="card-title">
            <div class="block">
                <a style="color: #757575;" class="hover" href="{{ route(config('constants.category.index')) }}">
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
        <form id="formValidate" method="POST" action="{{ route(config('constants.category.store')) }}">
            <div class="form-group">
                <div class="text-center">
                    <div id="sent-message-send" style="display: none"> </div>
                </div>
                <label for="">Наименование</label>
                <input type="text" name="description" value="" class="form-control" id="description"
                    aria-describedby="textHelp" placeholder="Категория" autocomplete="off">
                <small id="textHelp" class="form-text text-muted">Введите категорию</small>
            </div>
            <input class="btn btn-primary" type="submit" value="Отправить" />
            <a class="btn btn-secondary" href="{{ route(config('constants.category.index')) }}">Отменить</a>
        </form>
    </div>
</div>
@endsection
