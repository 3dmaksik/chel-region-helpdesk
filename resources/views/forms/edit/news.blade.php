@extends('layouts.app')
@section('row')
<div class="col-lg-12">
<div class="card mb-12">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Редактировать новость</h6>
        <div class="card-title">
            <div class="block" style="cursor: pointer;">
                <a style="color: #757575;" class="hover" href="{{ url()->previous() === url()->current() ? route(config('constants.news.index')): url()->previous()}}">
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
        <form id="formValidate" class="form-submit" method="POST" action="{{ route(config('constants.news.update'),$item['data']->id) }}">
            @method('PATCH')
            <div class="form-group">
                <label for="">Название</label>
                <input type="text" name="name" value="{{ $item['data']->name }}" class="form-control" id="name"
                    aria-describedby="textName" placeholder="Название" autocomplete="off" required>
                <small id="textName" class="form-text text-muted">Введите название новости</small>
            </div>
            <div class="form-group">
                <label for="">Описание</label>
                <input type="text" name="description" value="{{ $item['data']->description }}" class="form-control"
                    id="description" aria-describedby="textDescription" placeholder="Описание" autocomplete="off" required>
                <small id="textDesription" class="form-text text-muted">Введите описание новости</small>
            </div>
            <div class="form-group">
                <label for="news-text">Введите текст новости</label>
                <textarea class="wysiwyg form-control" id="news-text" rows="9"
                    name="news_text">{{$item['data']->news_text }}</textarea>
            </div>
            <div class="form-group" id="simple-date1">
                <label for="simpleDataInput">Дата и время создания</label>
                <div class="input-group date">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                    <input id="datetimepicker" name="created_at" type="text" class="form-control"
                        value="{{ $item['data']->created_at }}" id="simpleDataInput">
                </div>
            </div>
            <input class="btn btn-primary" type="submit" value="Отправить" />
            @if (url()->previous()!==url()->current())
            <a class="btn btn-secondary" href="{{ url()->previous() }}">Отменить</a>
            @endif
        </form>
    </div>
</div>
</div>
<script src="{{ mix('/js/editor.js') }}"></script>
@endsection
