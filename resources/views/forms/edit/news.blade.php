@extends('layouts.app')
@section('components.grid')
col-lg-12
@endsection
@section('row')
<div class="card mb-12">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Редактировать новость</h6>
        <div class="card-title">
            <div class="block">
                <a style="color: #757575;" class="hover" href="{{ route(config('constants.news.index')) }}">
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
        <form id="formValidate" method="POST" action="{{ route(config('constants.news.update'),$item->id) }}">
            @method('PATCH')
            <div class="form-group">
                <div class="text-center">
                    <div id="sent-message-send" style="display: none"> </div>
                </div>
                <label for="">Название</label>
                <input type="text" name="name" value="{{ $item->name }}" class="form-control" id="name"
                    aria-describedby="textName" placeholder="Название" autocomplete="off">
                <small id="textName" class="form-text text-muted">Введите название новости</small>
            </div>
            <div class="form-group">
                <label for="">Описание</label>
                <input type="text" name="description" value="{{ $item->description }}" class="form-control"
                    id="description" aria-describedby="textDescription" placeholder="Описание" autocomplete="off">
                <small id="textDesription" class="form-text text-muted">Введите описание новости</small>
            </div>
            <div class="form-group">
                <label for="news-text">Введите текст новости</label>
                <textarea class="wysiwyg form-control" id="news-text" rows="9"
                    name="news_text">{{ $item->news_text }}</textarea>
            </div>
            <div class="form-group" id="simple-date1">
                <label for="simpleDataInput">Дата и время создания</label>
                <div class="input-group date">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                    <input id="datetimepicker" name="created_at" type="text" class="form-control"
                        value="{{ $item->created_at }}" id="simpleDataInput">
                </div>
            </div>
            <input class="btn btn-primary" type="submit" value="Отправить" />
            <a class="btn btn-secondary" href="{{ route(config('constants.news.index')) }}">Отменить</a>
        </form>
    </div>
</div>
<script src="{{ mix('/js/editor.js') }}"></script>
@endsection
